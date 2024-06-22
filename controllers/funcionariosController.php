<?php
use models\Funcionario;
use models\Especialidad;
use models\Profesion;

final class funcionariosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Funcionarios',
            'funcionarios' => Funcionario::with(['especialidad','profesion'])->get()
            #select * from funcionarios
            #inner join especialidades ON especialidades.id = funcionarios.especialidad_id
            #inner join profesiones ON profesiones.id = funcionarios.profesion_id
        ];

        $this->_view->load('funcionarios/index', compact('options','msg_success','msg_error'));
    }

    public function create()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Nuevo Funcionario',
            'funcionario' => Session::get('data'),
            'process' => 'funcionarios/store',
            'send' => $this->encrypt($this->getForm()),
            'action' => 'create',
            'button' => 'Guardar',
            'especialidades' => Especialidad::select('id','nombre')->orderBy('nombre')->get(),
            'profesiones' => Profesion::select('id','nombre')->orderBy('nombre')->get()
        ];

        $this->_view->load('funcionarios/create', compact('options','msg_success','msg_error'));
    }

    public function store()
    {
        $this->validateForm('funcionarios/create',[
            'rut' => Filter::getText('rut'),
            'nombre' => Filter::getText('nombre'),
            'email' => $this->validateEmail(Filter::getPostParam('email')),
            'especialidad' => Filter::getText('especialidad'),
            'profesion' => Filter::getText('profesion')
        ]);

        if (!$this->validateRut(Filter::getText('rut'))) {
            Session::set('msg_error','Ingrese un RUT válido');
            $this->redirect('funcionarios/create');
        }

        $funcionario = Funcionario::select('id')->where('rut', Filter::getText('rut'))->first();

        if ($funcionario) {
            Session::set('msg_error','El funcionario ingresado ya existe... intente con otro');
            $this->redirect('funcionarios/create');
        }

        $funcionario = new Funcionario;
        $funcionario->rut = Filter::getText('rut');
        $funcionario->nombre = Filter::getText('nombre');
        $funcionario->email = Filter::getPostParam('email');
        $funcionario->especialidad_id = Filter::getInt('especialidad');
        $funcionario->profesion_id = Filter::getInt('profesion');
        $funcionario->save();

        Session::destroy('data');
        Session::set('msg_success','El funcionario se ha registrado correctamente');
        $this->redirect('funcionarios');
    }
}
