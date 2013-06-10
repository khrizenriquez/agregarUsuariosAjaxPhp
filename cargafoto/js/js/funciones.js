//funcion tomada de Cesar Cancino, pueden visitarlo en cesarcancino.com
function getXMLHTTPRequest()
{
    var req = false;
    try
      {
        req = new XMLHttpRequest(); /* p.e. Firefox */
      }
    catch(err1)
      {
      try
        {
         req = new ActiveXObject("Msxml2.XMLHTTP");
      /* algunas versiones IE */
        }
      catch(err2)
        {
        try
          {
           req = new ActiveXObject("Microsoft.XMLHTTP");
      /* algunas versiones IE */
          }
          catch(err3)
            {
             req = false;
            }
        }
      }
    return req;
}

var miPeticion = getXMLHTTPRequest();
//***************************************************************************************
function from(id)
{
        var mi_aleatorio=parseInt(Math.random()*99999999);//para que no guarde la p�gina en el cach�...
        var vinculo="scriptsPHP/paginacion.php?pos="+id+"&rand="+mi_aleatorio;
        //alert(vinculo);
        miPeticion.open("GET",vinculo,true);//ponemos true para que la petici�n sea asincr�nica
        miPeticion.onreadystatechange=miPeticion.onreadystatechange=function(){
       //alert("ready_State="+miPeticion.readyState);
           if (miPeticion.readyState==4)
           {
                               //alert(miPeticion.readyState);
                   //alert("status ="+miPeticion.status);
                   if (miPeticion.status==200)
                   {
                            //alert(miPeticion.status);
                           //var http=miPeticion.responseXML;
                           //alert("http="+http);
                           var http=miPeticion.responseText;
                           document.getElementById("listaUsuarios").innerHTML= http;

                   }
           }

    }
    miPeticion.send(null);

}
