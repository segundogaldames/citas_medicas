<?php
use models\Role;

class rolesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Roles',
            'roles' => Role::select('id','nombre')->orderBy('id','desc')->get()
        ];

        #select id, nombre from roles order by nombre
        $this->_view->load('roles/index', compact('options','msg_success','msg_error'));
    }

    #metodo get para cargar un formulario de registro
    public function create()
    {
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Roles',
            'rol' => Session::get('data'),
            'process' => 'roles/store',
            'send' => $this->encrypt($this->getForm()),
            'action' => 'create',
            'button' => 'Guardar'
        ];

        $this->_view->load('roles/create', compact('options','msg_success','msg_error'));
    }

    #metodo post para gestionar el registro de los roles
    public function store()
    {
        $this->validateForm('roles/create',[
            'nombre' => Filter::getText('nombre')
        ]);

        #comprobar que el rol ingresado no exista
        #select id from roles where nombre = ?
        $rol = Role::select('id')->where('nombre', Filter::getText('nombre'))->first();

        if ($rol) {
            Session::set('msg_error', 'El rol ingresado ya existe... intenta con otro');
            $this->redirect('roles/create');
        }

        $rol = new Role;
        $rol->nombre = Filter::getText('nombre');
        $rol->save();
        
        Session::destroy('data');
        Session::set('msg_success','El rol se ha registrado correctamente');
        $this->redirect('roles');
    }

    public function view($id = null)
    {
        Validate::validateModel(Role::class, $id, 'error/error');
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Detalle Rol',
            'rol' => Role::find(Filter::filterInt($id))
        ];

        $this->_view->load('roles/view', compact('options','msg_success','msg_error'));
    }

    public function edit($id = null)
    {
        Validate::validateModel(Role::class, $id, 'error/error');
        list($msg_success, $msg_error) = $this->getMessages();

        $options = [
            'title' => 'Editar Rol',
            'rol' => Role::select('id','nombre')->find(Filter::filterInt($id)),
            'process' => "roles/update/{$id}",
            'send' => $this->encrypt($this->getForm()),
            'action' => 'edit',
            'button' => 'Modificar'
        ];

        $this->_view->load('roles/edit', compact('options','msg_success','msg_error'));
    }

    public function update($id = null)
    {
        Validate::validateModel(Role::class, $id, 'error/error');
        $this->validatePUT();

        $this->validateForm("roles/edit/{$id}",[
            'nombre' => Filter::getText('nombre')
        ]);

        $rol = Role::find(Filter::filterInt($id));
        $rol->nombre = Filter::getText('nombre');
        $rol->save();
        
        Session::destroy('data');
        Session::set('msg_success','El rol se ha modificado correctamente');
        $this->redirect('roles/view/' . $id);
    }
}
