<?php
use models\Especialidad;

class especialidadesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Especialidades',
            'especialidades' => Especialidad::select('id','nombre')->orderBy('id','desc')->get()
        ];

        $this->_view->load('especialidades/index', compact('options','msg_success','msg_error'));
    }

    #metodo get para cargar un formulario de registro
    public function create()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Nueva Especialidad',
            'especialidad' => Session::get('data'),
            'process' => 'especialidades/store',
            'send' => $this->encrypt($this->getForm()),
            'action' => 'create',
            'button' => 'Guardar'
        ];

        $this->_view->load('especialidades/create', compact('options','msg_success','msg_error'));
    }

    #metodo post para gestionar el registro de los roles
    public function store()
    {
        $this->validateForm('especialidades/create',[
            'nombre' => Filter::getText('nombre')
        ]);

        $especialidad = Especialidad::select('id')->where('nombre', Filter::getText('nombre'))->first();

        if ($especialidad) {
            Session::set('msg_error', 'La especialidad ingresada ya existe... intenta con otra');
            $this->redirect('especialidades/create');
        }

        $especialidad = new Especialidad();
        $especialidad->nombre = Filter::getText('nombre');
        $especialidad->save();
        
        Session::destroy('data');
        Session::set('msg_success','La especialidad se ha registrado correctamente');
        $this->redirect('especialidades');
    }

    public function view($id = null)
    {
        Validate::validateModel(Especialidad::class, $id, 'error/error');
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Detalle Especialidad',
            'especialidad' => Especialidad::find(Filter::filterInt($id))
        ];

        $this->_view->load('especialidades/view', compact('options','msg_success','msg_error'));
    }

    public function edit($id = null)
    {
        Validate::validateModel(Especialidad::class, $id, 'error/error');
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Editar Especialidad',
            'especialidad' => Especialidad::select('id','nombre')->find(Filter::filterInt($id)),
            'process' => "especialidades/update/{$id}",
            'send' => $this->encrypt($this->getForm()),
            'action' => 'edit',
            'button' => 'Modificar'
        ];

        $this->_view->load('especialidades/edit', compact('options','msg_success','msg_error'));
    }

    public function update($id = null)
    {
        Validate::validateModel(Especialidad::class, $id, 'error/error');
        $this->validatePUT();

        $this->validateForm("especialidades/edit/{$id}",[
            'nombre' => Filter::getText('nombre')
        ]);

        $especialidad = Especialidad::find(Filter::filterInt($id));
        $especialidad->nombre = Filter::getText('nombre');
        $especialidad->save();
        
        Session::destroy('data');
        Session::set('msg_success','La especialidad se ha modificado correctamente');
        $this->redirect('especialidades/view/' . $id);
    }
}
