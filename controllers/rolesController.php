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
}
