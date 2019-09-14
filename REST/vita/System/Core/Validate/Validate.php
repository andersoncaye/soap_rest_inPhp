<?php

namespace Vita\System\Core\Validate;

/**
* Validacao
*
* Classe responsavel por fornecer funções para tratar e validar as
* informações que serao processados
* pelo sistema, limpando, e evitando que dados indesejados sejam registrados.
*
* @package     Vita
* @author      wandeco sans - sans.pds@gmail.com
* @copyright   Copyright (c) 2014
* @license
* @link
* @since       Version 1.0
* @filesource
*/

/*
* @interface : Metodos publicos
* (+) text
* (+) textOnlyNoSpaces
* (+) number
* (+) email
* (+) money
* (+) phome
* (+) cpf
* (+) cnpj
*/

class Validate
{
    public function __construct(){}

    // MySQL Real Scape String (Generico!)
    public function mres($value){
        return str_replace(
            array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a"),
            array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z"),
            $value);
    }

    /**
     * Essa funcao tem a finalidade de evitar sql injection e fazer um trim nas strings recebidas
     * @param type $value
     * @return type
     */
    public function make_safe( $pvariable )
    {
       //$variable = strip_tags( mysql_real_escape_string( trim( $pvariable ) ) );
       $variable = strip_tags($this->mres(trim($pvariable)));
       return $variable;
    }

    function text( $param ) {
        return $this->make_safe( $param );
    }

    function html( $param ){
        return $this->mres( trim($param) );
    }

    function textOnlyNoSpaces( $param ) {
        $tmp = $this->make_safe( $param );
        return str_replace(' ','',$tmp );
    }

    # alias facil de lembrar para a funcao acima
    function textns($param){
        return $this->textOnlyNoSpaces( $param );
    }

    /**
     * Remove tudo que nao seja numero ou o sinal de menos
     * em uma string. Remove tambem
     * espaços.
     *
     * @param  mixed - string ou int
     * @return int
     */
    function number( $param ) {
        $variable = $this->make_safe( $param );
        # return preg_replace( "/[^0-9]/","",$variable );
        return (int)preg_replace('/[^\d-]+/','',$variable);
    }

    function email($email){
        // return filter_var( $email, FILTER_VALIDATE_EMAIL );
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        if (preg_match($pattern, $email) === 1) {
            return true;
        }
        return false;
    }

    /**
     * Remove o acento das palavras, substituindo por palavras 
     * semelhantes
     *
     * @param $str
     * @return mixed
     * @link http://myshadowself.com/coding/php-function-to-convert-accented-characters-to-their-non-accented-equivalant/
     */
    function replace_accents($str){
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
    }
    /**
     * Deixa apenas numeros, pontos, e virgulas na string
     *
     * @param string|int $number
     * @return string - monetario
     */
    function money($number){
       return trim( preg_replace( "/[^0-9.,]+/i", "", $number ) );
    }

    /**
     * Deixa apenas numeros, hiffens, barra,
     *
     * @param string|int $number
     * @return string - monetario
     */
    function vt_datetime($__value__){
       // return trim( preg_replace( "/[^0-9.,]+/i", "", $__value__ ) );
       // @todo - precisa implementar essa validacao
       return $__value__;
    }

    /**
    * Faz a "normatizacao"(não validação) de um valor decimal para ser inserido no DB MySQL
    * @nota: Função Beta.
    *
    * @param string - valor a ser convertido em decimal
    * @return decimal - exemplo input "R$1.00 0,a00" output "1000.00"
    */
    function dcmm( $valor = null, $precisao = null )
    {
        # remove o que nao for necessario
        $valor = preg_replace('/[^\d-,.]+/','',$valor);

        # temos um dado para trabalhar ?
        if(empty($valor)||null==$valor) return 0.00;

        # temos uma precisao setada ?
        # default
        $precisao = (null != $precisao && is_numeric($precisao)) ? str_repeat("0", $precisao) : "";

        # procurando por um ponto...
        $ponto_pos = strpos($valor,".");
        # porcurando por virgula...
        $virgu_pos = strpos($valor,",");
        # se nao temos pontos nem virgulas, apenas numero ex: -1000 ou 1000 entao retornamos o valor
        if( $ponto_pos === false && $virgu_pos === false && (is_numeric(preg_replace('/[^0-9]/s','',$valor))))
            return $this->number($valor) . $precisao;

        # verifica se temos realmente um numero para trabalhar!
        if(!is_numeric(preg_replace('/[^0-9]/s','',$valor))) return 0.00;

        # input 12,345.67 output 12345.67
        if($ponto_pos > 0 && $virgu_pos > 0 && $ponto_pos > $virgu_pos)
            return str_replace(",", "", $valor);

        # input 1.12345,67 output 112345.67
        if($ponto_pos > 0 && $virgu_pos > 0 && $ponto_pos < $virgu_pos)
            return str_replace(",",".",str_replace(".","",$valor));

        # input 12345.67 output 12345.67
        if($ponto_pos > 0 && $virgu_pos === false)
            return $valor;

        # input 12,34567 output 12.34567
        if($ponto_pos === false && $virgu_pos > 0)
            return str_replace(",", ".", $valor);

        return 0.00;
    }

    /**
     * retorna apenas numeros sem letras, caracteres especiais ou pontos e tracos
     * @param string $telefone
     * @return type
     */
    function phone($telefone){
       return trim( preg_replace( "/[^0-9]+/i", "", $telefone ) );
    }

    /**
     * Verifica se um Número de CPF é valido
     * @string - numero do cpf com ou sem pontos e hifen
     * @return bool - true caso valido
     **/
    public function cpf( $cpf ){
        // determina um valor inicial para o digito $d1 e $d2
        // pra manter o respeito ;)
        $d1 = 0;
        $d2 = 0;
        // remove tudo que não seja número
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        // lista de cpf inválidos que serão ignorados
        $ignore_list = array(
            '00000000000',
            '01234567890',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999'
            );
            // se o tamanho da string for dirente de 11 ou estiver
            // na lista de cpf ignorados já retorna false
        if(strlen($cpf) != 11 || in_array($cpf, $ignore_list)){
            return false;
        } else {
            // inicia o processo para achar o primeiro
            // número verificador usando os primeiros 9 dígitos
            for($i = 0; $i < 9; $i++){
            // inicialmente $d1 vale zero e é somando.
            // O loop passa por todos os 9 dígitos iniciais
                $d1 += $cpf[$i] * (10 - $i);
            }
            // acha o resto da divisão da soma acima por 11
            $r1 = $d1 % 11;
            // se $r1 maior que 1 retorna 11 menos $r1 se não
            // retona o valor zero para $d1
            $d1 = ($r1 > 1) ? (11 - $r1) : 0;
            // inicia o processo para achar o segundo
            // número verificador usando os primeiros 9 dígitos
            for($i = 0; $i < 9; $i++) {
            // inicialmente $d2 vale zero e é somando.
            // O loop passa por todos os 9 dígitos iniciais
                $d2 += $cpf[$i] * (11 - $i);
            }
            // $r2 será o resto da soma do cpf mais $d1 vezes 2
            // dividido por 11
            $r2 = ($d2 + ($d1 * 2)) % 11;
            // se $r2 mair que 1 retorna 11 menos $r2 se não
            // retorna o valor zeroa para $d2
            $d2 = ($r2 > 1) ? (11 - $r2) : 0;
            // retona true se os dois últimos dígitos do cpf
            // forem igual a concatenação de $d1 e $d2 e se não
            // deve retornar false.
            return (substr($cpf, -2) == $d1 . $d2) ? true : false;
        }
    }

    /**
     * Verifica se um Número de CNPJ é valido
     * @string - numero do CNPJ com ou sem pontos e hifen
     * @return bool - true caso valido
     **/
    public function cnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14) return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++){
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto)) return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++){
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

    // checa se uma string e' um data 
    function isDate($x){
        if(substr_count(($x = str_replace(array("/","."),"-",trim($x))),"-") == 2)
            return strlen(preg_replace('/[^\d]+/','',$x)) > 6;
        return false;
    }

    /**
    * Normatiza uma data para o padrao MySQL
    * @param  string - $val string contendo a data a ser normatizada
    * @return string - data no formato para insercao do mysql
    */
    public function mysqlDate($date = null)
    {
        # para caso em que a normatizacao nao pode prosseguir devido
        # a informacoes incorretas, esta data sera retornada.
        $__default_date_err_norm = '1970-01-01 00:00:00';
        
        if(null == $date ) return $__default_date_err_norm;
        $__date = trim($date);
        
        $date = str_replace(array('/','.',',','\\'),'-',trim($date));
        
        # temos data e tempo ? dd-mm-yyyy hh:ii:ss
        if(!(strpos($date," ") === false) ){
            list($date,$time) = explode(" ",$date);
            //@todo - aqui normatiza tempo
        }
        
        # filtrando apenas por caracteres validos
        $date = preg_replace("/[^0-9-]+/i","",$date);
        
        # tamanho da data e valido ?
        if (strlen($date) < 8){
            return $__default_date_err_norm;
        }
        
        # verificando qual info e' ano, mes e dia
        $_arr = explode("-",$date);
        
        $ano = strlen($_arr[2]) == 4 ? 2 : (strlen($_arr[0]) == 4 ? 0 : null);
        $mes = ($_arr[1] > 12 && $_arr[1] < 31) ? ($ano == 0 ? 2: 0) : 1;
        $dia = ($_arr[1] > 12 && $_arr[1] < 31) ? 1 : ($ano == 0 ? 2 : 0);

        # verifica se ano, mes e dia estao dentro de faixas aceitas
        if(($_arr[$ano]>0)&&($_arr[$mes]>0&&$_arr[$mes]<=12)&&($_arr[$dia]>0&&$_arr[$dia]<=31))
            return "{$_arr[$ano]}-{$_arr[$mes]}-{$_arr[$dia]}".(isset($time)?" {$time}":"");
        return $__default_date_err_norm;
    }
}
