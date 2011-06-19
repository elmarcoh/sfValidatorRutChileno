<?php

/* Copyright (c) 2008 José Joaquín Núñez (josejnv@gmail.com) http://joaquinnunez.cl
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-2.0.php)
 * Use only for non-commercial usage.
 *
 * Version : 0.1
 */

class sfRutValidator extends sfValidatorBase
{
  public function doClean($value)
  {
    $r=strtoupper(preg_replace('[^0-9kK]','',$value));
    $sub_rut=substr($r,0,strlen($r)-1);
    $sub_dv=substr($r,-1);
    $x=2;
    $s=0;
    for ($i=strlen($sub_rut)-1;$i>=0;$i--)
    {
      if ( $x >7 )
      {
        $x=2;
      }
      $s += $sub_rut[$i]*$x;
      $x++;
    }
    $dv=11-($s%11);
    if ( $dv==10 )
    {
      $dv='K';
    }
    if ( $dv==11 )
    {
      $dv='0';
    }
    if ( $dv==$sub_dv )
    {
      return $r;
    }
    else
    {
      //$error = $this->getParameterHolder()->get('rut_error');
      throw new sfValidatorError($this,'invalid_rut' ,array());
    }
  }

  /**
   * Configuracion del validador
   *
   * @return void
   * @author Marcos Sánchez
   **/
  public function configure($options=array(), $messages=array())
  {
    $this->addMessage('invalid_rut', "El RUT ingresado no es válido");
  }

  public function initialize ($contexto, $parametros = null)
  {
    // Inicializar la clase padre
    parent::initialize($contexto);
    // Valores por defecto de los parámetros
    $this->getParameterHolder()->set('rut_error', 'El rut ingresado es incorrecto.');
    // Establecer los parámetros
    $this->getParameterHolder()->add($parametros);
    return true;
  }
}

?>

