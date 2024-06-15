<?php
use models\Profesion;

class profesionesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Profesiones',
            'profesiones' => Profesion::select('id','nombre')->orderBy('id','desc')->get()
        ];

        $this->_view->load('profesiones/index', compact('options','msg_success','msg_error'));
    }

    #metodo get para cargar un formulario de registro
    public function create()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Nueva Profesión',
            'profesion' => Session::get('data'),
            'process' => 'profesiones/store',
            'send' => $this->encrypt($this->getForm()),
            'action' => 'create',
            'button' => 'Guardar'
        ];

        $this->_view->load('profesiones/create', compact('options','msg_success','msg_error'));
    }

    #metodo post para gestionar el registro de los roles
    public function store()
    {
        $this->validateForm('profesiones/create',[
            'nombre' => Filter::getText('nombre')
        ]);

        #comprobar que el rol ingresado no exista
        #select id from roles where nombre = ?
        $profesion = Profesion::select('id')->where('nombre', Filter::getText('nombre'))->first();

        if ($profesion) {
            Session::set('msg_error', 'La profesión ingresada ya existe... intenta con otra');
            $this->redirect('profesiones/create');
        }

        $profesion = new Profesion;
        $profesion->nombre = Filter::getText('nombre');
        $profesion->save();
        
        Session::destroy('data');
        Session::set('msg_success','La profesión se ha registrado correctamente');
        $this->redirect('profesiones');
    }

    public function view($id = null)
    {
        Validate::validateModel(Profesion::class, $id, 'error/error');
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Detalle Profesión',
            'profesion' => Profesion::find(Filter::filterInt($id))
        ];

        $this->_view->load('profesiones/view', compact('options','msg_success','msg_error'));
    }

    public function edit($id = null)
    {
        Validate::validateModel(Profesion::class, $id, 'error/error');
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Editar Profesión',
            'profesion' => Profesion::select('id','nombre')->find(Filter::filterInt($id)),
            'process' => "profesiones/update/{$id}",
            'send' => $this->encrypt($this->getForm()),
            'action' => 'edit',
            'button' => 'Modificar'
        ];

        $this->_view->load('profesiones/edit', compact('options','msg_success','msg_error'));
    }

    public function update($id = null)
    {
        Validate::validateModel(Profesion::class, $id, 'error/error');
        $this->validatePUT();

        $this->validateForm("profesiones/edit/{$id}",[
            'nombre' => Filter::getText('nombre')
        ]);

        $profesion = Profesion::find(Filter::filterInt($id));
        $profesion->nombre = Filter::getText('nombre');
        $profesion->save();
        
        Session::destroy('data');
        Session::set('msg_success','La profesión se ha modificado correctamente');
        $this->redirect('profesiones/view/' . $id);
    }
}
