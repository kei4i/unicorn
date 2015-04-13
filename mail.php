<?php
   function Utf8ToWin($fcontents) 
   {
      $out = $c1 = "";
      $byte2 = false;
      for ($c = 0; $c < strlen($fcontents); $c++)
      {
         $i = ord($fcontents[$c]);
         if ($i <= 127)
         {
            $out .= $fcontents[$c];
         }
         if ($byte2) 
         {
            $new_c2 = ($c1 & 3) * 64 + ($i & 63);
            $new_c1 = ($c1 >> 2) & 5;
            $new_i = $new_c1 * 256 + $new_c2;
            if ($new_i == 1025) 
            {
                $out_i = 168;
            } 
            else 
            {
               if ($new_i == 1105) 
               {
                   $out_i = 184;
               } 
               else 
               {
                   $out_i = $new_i - 848;
               }
            }
            $out .= chr($out_i);
            $byte2 = false;
         }
         if (($i >> 5) == 6) 
         {
            $c1 = $i;
            $byte2 = true;
         }
      }
      return $out;
   }

   function GetInputVal( $val_name )
   {
      $val = "";
      if( isset( $_GET[$val_name] ) )
         $val = $_GET[$val_name];
      if( isset( $_POST[$val_name] ) )
      {
         $val = utf8_decode( $_POST[$val_name] );
         $len = strlen( $val );
         if( $len > 0 )
         {
            $count = substr_count( $val, '?');
            if( $count > $len - $count )
               $val = Utf8ToWin( $_POST[$val_name] );
         }
      }
      return $val;
   }

$recepient = "ilovegirlsinaglasses@gmail.com";
$sitename = "Портфолио Екатерины";

$name = GetInputVal( "name" );
$phone = GetInputVal( "phone" );
$text = GetInputVal( "text" );

$pagetitle = "Сообщение с сайта \"$sitename\"";
$message = "Имя: $name\n\n";
$message .= "Телефон: $phone\n\n";
$message .= "Текст: \n$text";

//mail( $recepient, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $recepient" );
mail( $recepient, $pagetitle, $message, "Content-type: text/plain; charset=windows-1251\nFrom: EkaMax site <noreply@ekamax.ru>" );

header("Location: index.html"); 
?>