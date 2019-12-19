<?php 
class Controller 
{
    public $base = "jmerrill/calendar/public/home";
    public function model($model) 
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }    
    
    public function view($view, $data=[], $layoutPath, $model=null)
    {
        $MODEL = $model;
        ob_start();
        require '../app/views/' . $view . '.php';
        $MASTER_CONTENT = ob_get_clean();
        require_once $layoutPath;
        
    }
   /* protected function RenderPage ($pageName, $layoutPath, $viewPath) {
        ob_start();
        include $viewPath;
        $MASTER_CONTENT = ob_get_clean();
        require_once $layoutPath;
    }*/
    
    /*protected function RedirectToController ($controller, $action = null) {
        if ($action == NULL) {
            header('Location: ?c='.$controller);
        } else {
            header('Location: ?c='.$controller.'&a='.$action);
        }
        die();
    }*/
    
    /*protected function RenderJson ($model) {
        header('Content-type: application/json');
        $json = json_encode($model);
        echo $json;
    }*/
}
?>