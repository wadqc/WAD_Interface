<?php

    class templateParser {

        var $output;

        function templateParser($templateFile='default_template.htm'){
              //header('Content-type: application/msword');
              //header('Content-type: application/msword');
              //header("Content-Transfer-Encoding: binary");
              //(file_exists($templateFile))?$this->output=file_get_contents($templateFile,null):die('Error:Template
              //file '.$templateFile.' not found');
              $handle = fopen($templateFile, "rb");
              $this->output = fread($handle, filesize($templateFile));
              fclose($handle);
        }

        function parseTemplate($tags=array()){

              if(count($tags)>0){

                   foreach($tags as $tag=>$data){

                        $data=(file_exists($data))?$this->parseFile($data):$data;
                        $left=strpos ($this->output,$tag,0);
                        //$right=strpos ($this->output,'}',$left);
                        //$code=substr($this->output,$left+1,$right-$left-1);
                        //printf("left=%s and right= %s and field=%s",$left,$right,$code);
                        //exit();
                        //$this->output=str_replace('{'.$tag.'}',$data,$this->output);
                        //$this->output=substr_replace('{'.$tag.'}',$data,$this->output);
                        //printf("left=%d",$left);
                        $ary[0] = "ASCII"; 
                        $ary[1] = "JIS";
                        $ary[2] = "EUC-JP";
                        echo mb_detect_encoding($this->output,$ary);
                        if ($left>0)
                        {
                          $this->output=substr_replace($this->output,$data,$left,strlen($tag));
                        }
                        //$this->output=str_replace($tag,$data,$this->output);
                   }

              }

              else {

                   die('Error: No tags were provided for replacement');

              }

        }

        function parseFile($file){

              ob_start();

              include($file);

              $content=ob_get_contents();

              ob_end_clean();

              return $content;

        }

        function display(){

              header ("Cache-Control: must-revalidate, post-check=0,pre-check=0");
              header("Content-type: application/msword");
              //header('Content-Length: '.strlen($this->output));
              $name='naampje.doc';
              header("Content-disposition: attachment; filename=$name");
              echo $this->output;

        }

    } 

?>