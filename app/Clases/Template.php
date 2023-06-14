<?php
namespace App\Clases;
class Template{
    protected string $content;
    protected string $form;
    private string $current_path = __DIR__.'/../../dist/templates/';
    
    protected function get_php_template(string $path, ?array $result):string{
        ob_start();
        if($result){
            extract($result);
        }                
        include_once($this->current_path.$path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    protected function get_static_template(string $path, ?array $find, ?array $replace):string{
        $content = file_get_contents($this->current_path.$path);
        $content  = str_replace($find, $replace, $content);
        return $content;
    }

    protected function get_base_template(string $title, string $content,?string $form):string{
        $head = $this->get_php_template('Head.php',null);         
        $nav = $this->get_php_template('Nav.php',null);        
        $main = $this->get_static_template(
            'Main.php',
            ['@title','@content'],
            [$title,$content]
        );
        $modal =$this->get_static_template(
            'Modal.php',
            ['@title','@form'],
            [$title,$form]
        );
        $aside = $this->get_static_template('Aside.php',null,null);
        $base = $this->get_static_template('Base.php',[
            '@head',
            '@nav',
            '@main',
            '@modal',
            '@aside'
        ],[
            $head,
            $nav,
            $main,
            $modal,
            $aside
        ]);
        return $base;
    }
    protected function load_default_components(
        string $folder,
        array $datos        
    ){                        
        if(!isset($datos['contents']) || !isset($datos['form']))
                throw new \Exception('ERROR: UNDEFINED VIEW');

        $is_method_put = $_SERVER['REQUEST_METHOD']=='PUT';
        $file = $is_method_put?'UpdateForm.php':'Table.php';
        $contents =$is_method_put?$datos:$datos['contents'];        
        $this->content = $this->get_php_template("components/$folder/$file", $contents);
        $this->form = $this->get_php_template("components/$folder/Form.php",$datos['form']);
    }
}