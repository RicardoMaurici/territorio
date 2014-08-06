<?php
/*
* Classe Upload
* Executa o upload de arquivos
* @Author = Diego Henrique (diegoholiveira@yahoo.com.br)
*/
class Upload {

    private $file;        // Armazena o arquivo
    private $fileName;    // Armazena o novo nome do arquivo
    private $single;    // Armazena o tipo de upload
    
    /*
     * Metodo construtor
     * @param $fieldName = Nome do campo que vai ser recebido
     */
    public function __construct( $fieldName ) {
        
        // Verifica se existe mais de um arquivo
        $i = 0;
        
        // Verifica se o upload � multiplo
        if (isset($_FILES[$fieldName]['name']) && is_array($_FILES[$fieldName]['name'])) {
            
            $this->single = false;
            
            while (isset($_FILES[$fieldName]['error'][$i]) && $_FILES[$fieldName]['error'][$i] == UPLOAD_ERR_OK) {
                
                $tmp_file[$i]['name']        = $_FILES[$fieldName]['name'][$i];
                $tmp_file[$i]['type']        = $_FILES[$fieldName]['type'][$i];
                $tmp_file[$i]['error']        = $_FILES[$fieldName]['error'][$i];
                $tmp_file[$i]['size']        = $_FILES[$fieldName]['size'][$i];
                $tmp_file[$i]['tmp_name']    = $_FILES[$fieldName]['tmp_name'][$i];
                
                $tmp_names[$i]    = $this->cleanFileName($tmp_file[$i]['name']);
                
                $this->file     = $tmp_file;
                $this->fileName = $tmp_names;
                
                $i++;
            }
            
        }
        else if (isset($_FILES[$fieldName]['name']) && is_string($_FILES[$fieldName]['name'])) {
            
            $this->single = true;
            
            // Verifica se o arquivo passado � valido
            if ( $_FILES[$fieldName]['error'] == UPLOAD_ERR_OK ) {

                $this->file        = $_FILES[$fieldName];
                $this->fileName = $this->cleanFileName($this->file['name']);

            }

        }

    }
    
    /*
     * Metodo cleanFileName
     * Remove acentos, espa�os e caracteres especiais
     * @param $string = string a ser limpa
     */
    private function cleanFileName( $string ) {
        
        // Converte todos os caracteres para minusculo
        $string = strtolower($string);

        // Remove os acentos
        $string = eregi_replace('[a�����]', 'a', $string);
        $string = eregi_replace('[e����]', 'e', $string);
        $string = eregi_replace('[i����]', 'i', $string);
        $string = eregi_replace('[o�����]', 'o', $string);
        $string = eregi_replace('[u����]', 'u', $string);
        
        // Remove o cedilha e o �
        $string = eregi_replace('[�]', 'c', $string);
        $string = eregi_replace('[�]', 'n', $string);
        
        // Substitui os espa�os em brancos por underline
        $string = eregi_replace('( )', '_', $string);
        
        // Remove hifens duplos
        $string = eregi_replace('--', '_', $string);
        
        return $string;
        
    }
    
    /*
     * Metodo upload
     * Executa o upload
     * @param $path = caminho onde ser� salvo o arquivo
     * @param $replace = indica se o arquivo pode substituir
     * outro arquivo com o mesmo nome
     */
    public function upload( $path, $replace = false ) {
        
        // Seta o limite de execu��o em zero para evitar erros
        set_time_limit(0);
        
        // Verifica se o diretorio passado como parametro existe
        if (!is_dir($path)) {
            @mkdir( $path );
        }
        
        if ($this->single) {
            
            // Verifica se � para substituir o arquivo
            if (!$replace) {
            
                // verifica se � o arquivo existe
                if ( file_exists( sprintf("%s/%s", $path, $this->fileName) )  ) {
                    return "O arquivo j� existe na pasta indicada!";
                }
                
            }
            
            if (move_uploaded_file( $this->file['tmp_name'], sprintf( "%s/%s", $path, $this->fileName ) )) {
                return true;
            }
            else {
                return "Erro ao fazer o upload do arquivo!";
            }
            
        }
        else {
            
            // Armazena os erros
            $erros = array();
            
            // Verifica se � para substituir o arquivo
            if (!$replace) {
                
                for ($i = 0; $i < count($this->file); $i++) {
                    
                    // verifica se � o arquivo existe
                    if ( file_exists( sprintf("%s/%s", $path, $this->fileName[$i]) )  ) {
                         $erros[] = sprintf(
                             "O arquivo %s j� existe na pasta indicada!",
                             $this->fileName[$i]
                         );
                    }
                    
                }
                
                if (count($erros)) return $erros;
                
            }
            
            for ($i = 0; $i < count($this->file); $i++) {
                
                if (!move_uploaded_file( $this->file[$i]['tmp_name'], sprintf( "%s/%s", $path, $this->fileName[$i] ) )) {
                    $erros[] = sprintf(
                        "Erro ao fazer o upload do arquivo %s!",
                        $this->fileName[$i]
                    );
                }

            }

            if (count($erros)) return $erros;
            else return true;

        }

    }
    
    /*
     * Metodo getFileName
     * Retorna o nome do arquivo em upload simples
     * Retorna um vetor com os nomes dos arquivos em uploads multiplo
     */
    public function getFileName() {
        return $this->fileName;
    }
    
    /*
     * Metodo getExtension
     * Retorna a extens�o do arquivo
     */
    public function getExtension() {
        if ($this->single){
			$extension =  strrchr( $this->fileName, "." );
			return substr($extension,1);
		}else{
            if(is_null($this->fileName)) { return null;}
            $filenames = $this->fileName;
            $extensoes = array();
            foreach($filenames as $file){
                $extension = strrchr( $file, "." );
                $extensoes[] = substr($extension,1);
            }
            return $extensoes;
        }
    }

}