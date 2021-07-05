<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Factura;
use App\Models\Bitacora;


class FacturaController extends Controller
{

    // By CIRG - Protejer la ruta.
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Factura::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        $usuario = auth()->user()->id;
        $usuariorole = User::findOrFail($usuario);

        if($usuariorole->hasRole('administrador'))
        {
            $facturas = Factura::fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idfactura')->paginate(20);
        }
        else
        {
            $facturas = Factura::usuario($usuario)->fecha($vfecha)->busqueda($vbusqueda)->orderByDesc('fecha')->orderByDesc('idfactura')->paginate(20);
        }

        return view('facturas.lista', compact('page', 'vfecha', 'vbusqueda', 'facturas'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Vauto::class);

        $page = $request->page;
        $vfecha = $request->vfecha;
        $vbusqueda = $request->vbusqueda;

        return view('facturas.crear', compact('page', 'vfecha', 'vbusqueda'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vauto::class);

        $request->validate([
            'fecha' => 'required',
            'numero' => 'required',
            'proveedor' => 'required'
        ]);

        $nuevo = new Factura();
        $fechaformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->fecha)));
        $nuevo->fecha = $fechaformat;
        $nuevo->numero = $request->numero;
        $nuevo->proveedor = $request->proveedor;
        $nuevo->monto = $request->monto;
        $nuevo->saldo = $request->saldo;
        $pagoformat = date('Y-m-d', strtotime(str_replace('/', '-', $request->pago)));
        $nuevo->pago = $pagoformat;
        $nuevo->fkusuario = auth()->user()->id;
        if(isset($request->activo))
        {
            $nuevo->activo = 1;
        }
        else
        {
            $nuevo->activo = 0;
        }
        $nuevo->save();

        $bitacora = new Bitacora();
        $bitacora->fkusuario = auth()->user()->id;
        $bitacora->operacion = 'Factura agregada con id:'.$nuevo->idfactura;
        $bitacora->fecha = date('Y-m-d H:i:s');
        $bitacora->ip = $request->ip();
        $bitacora->pc = gethostname();
        $bitacora->save();

        return redirect('/facturas?page='.$request->page.'&vfecha='.$request->vfecha.'&vbusqueda='.$request->vbusqueda)->with('mensaje','¡Factura agregada correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
