<?php
namespace Views;
class BaseTemplate{
    protected function get_php_template(string $path, ?array $result):string{
        ob_start();
        if($result){
            extract($result);
        }
        include_once(__DIR__.'/'.$path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    protected function get_static_template(string $path, ?array $find, ?array $replace):string{
        $content = file_get_contents(__DIR__.'/'.$path);
        $content  = str_replace($find, $replace, $content);
        return $content;
    }

    protected function get_base_template(string $title, string $content,?string $form):string{
        $head = $this->get_php_template('Templates/Head.php',null);         
        $nav = $this->get_php_template('Templates/Nav.php',null);        
        $main = $this->get_static_template(
            'Templates/Main.php',
            ['@title','@content'],
            [$title,$content]
        );
        $modal =$this->get_static_template(
            'Templates/Modal.php',
            ['@title','@form'],
            [$title,$form]
        );
        $aside = $this->get_static_template('Templates/Aside.php',null,null);
        $base = $this->get_static_template('Templates/Base.php',[
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
}