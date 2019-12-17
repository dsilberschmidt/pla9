<html>
<head>
    <meta charset="UTF-8">
    <title>Termo</title>
      <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="css/index.css" /> 

     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" /> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
  //$(document).ready(function() {
  //$(function() {
    //$('#datetimepicker6').datetimepicker();

     /* $('#datetimepicker6').on('dp.hide', function(e){ 
            //console.log("olii");
            doit({"HoradeTermo" : e.date.unix()});
            console.log(e.date.unix()); }) 
});
  });*/
</script>

    <script type="text/javascript">
        var ws;
       var wsUri = "ws://10.12.10.1:1880";
        var loc = window.location;

        if (loc.protocol === "https:") { wsUri = "wss:"; }
        wsUri += "/"+("mantenimiento","ws/mantenimiento");
        function wsConnect() {
            ws = new WebSocket(wsUri);
            ws.onmessage = function(msg) {
                var line = "";
                data = msg.data;

                var dataObj = jQuery.parseJSON(data);
            
                 if (typeof dataObj.Temperatura !== "undefined") {
                    TemperaturaReal = dataObj.Temperatura;
                }
                if (typeof dataObj.TemperaturaDeseada !== "undefined") {
                    TemperaturaDeseada = dataObj.TemperaturaDeseada;
                    
                   // console.log(dataObj.TemperaturaDeseada);
                }
                 if (typeof dataObj.Modo !== "undefined") {
                    if(dataObj.Modo=="false"){
                        Modo = "Automatico";
                    }else{
                        Modo = "Manual";
                    }
                }
                 if (typeof dataObj.Estado !== "undefined") {
                    if(dataObj.Estado=="ready"){
                        Estado = "Conectado";
                    }
                }

                   if (typeof dataObj.Estado !== "undefined") {
                    if(dataObj.Estado=="ready"){
                        Estado = "Conectado";
                    }


                }
//console.log(dataObj);
$(".treure").remove();
$.each(dataObj,function(index, value){
   // console.log('My array has at position ' + index + ', this value: ' + value);
   var obj= JSON.parse(value);
console.log(JSON.parse(value));

var obj_2= JSON.parse(obj.value);
 if (typeof obj_2.TimeStampInici !== "undefined") {
console.log(obj_2.TimeStampInici);
//
    $('.table tr:last').after(" <tr class='treure'><th>"+convert(obj_2.TimeStampInici)+"</th><td>"+convert(obj_2.TimeStampFinal)+"</td><td>"+obj_2.Temperatura_Dia+"</td></tr>");
    
 }



try {
  var c = $.parseJSON(value);
}
catch (err) {
  // Do something about the exception here
}

     if (typeof dataObj.value !== "undefined") {


     }
});
                  if (typeof dataObj.value !== "undefined") {
                    console.log("entremm a muerte");
console.log(dataObj.value);
var obj=JSON.parse(dataObj.value);
 if (typeof obj.Temperatura_Dia !== "undefined") {
 



var data_inici = new Date(obj.TimeStampInici);
console.log("aqui");
//onsole.log(data_inici);
//ola= new Date(data_inici).toISOString();
//console.log(data_prova);
//var data_final = new Date(obj.TimeStampFinal);
 
//$(".table tr:last").remove();
$('.table tr:last').after(" <tr><th>"+convert(obj.TimeStampInici)+"</th><td>"+convert(obj.TimeStampFinal)+"</td><td>"+obj.Temperatura_Dia+"</td></tr>");
    }




//$.each(dataObj.value, function(i, item) {
  //  alert(item.TimeStampInici);
//});


                    
                }



                 
            }

            ws.onclose = function(e) {
                setTimeout(function(){
                    wsConnect();
                },1000);
            };
        }
        
        function doit(m) {
            if (ws) { ws.send(m); }
        }	

        function enviar_dia(argument) {
            // body...
 
            var date_1 = $('#datetimepicker6').data("DateTimePicker").date();
            var date_2 = $('#datetimepicker7').data("DateTimePicker").date();

            if(!date_1 || !date_2){
                alert("Debes rellenar los campos");
                return false;
            }

             var msg = "";

            msg = '{"TimeStampInici" : "'+date_1.unix()+'","TimeStampFinal":"'+date_2.unix()+'","Temperatura_Dia":"'+$( ".temperatura_dia" ).val()+'"}';
            
        //    msg = '{"TimeStampInici" : ss}';

            doit(msg);  


        if( date_1 ){
             alert(date_1.unix());
     }

      if( date_2 ){
             alert(date_1.unix());
     }

        }



    </script>    
</head>
<body onload="wsConnect();">

  
    <div class="main-table container">
        <div class=" table-body">
            <div class="row header">
                <div class="col-md-2 col-md-2 col-sm-12  date-time border-blue">
                    <p id="date"></p>
                    <p id="time"></p>
                </div>
                <div class="col-md-10 col-md-10  title border-blue">SISTEMA DE CONTROL DEL TERMO:</div>
            </div>
            <div class="row content ">
                <div class="div-tab border-blue col-md-2 col-md-2" id="div-tab">                  
                    <p>ESTADO GENERAL DEL TERMO</p>
                    <ul id="tab-options">
                        <li id="temperatura"></li>
                        <li id="estado"></li>
                        <li id="modo"></li>                                       
                    </ul>
                </div>  
                <div class="div-tab border-blue col-md-10 col-md-10" id="div-tab">
                    <ul id="tab-options">
                        <li id="temperaturaDeseada">Temperatura Deseada: XXXXX ºC</li>
                        <li class="title border-blue" style="cursor:pointer;" id="Subir" onclick="subirTemp()">Subir Temperatura</li>
                        <li class="title border-blue" style="cursor:pointer;" id="Bajar" onclick="bajarTemp()">Bajar Temperatura</li>                
                       
                    </ul>
                    <h3> Calendario de dias del termostato</h3>
                 <div class="">
    <div class='col-md-5'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker6'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-md-5'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker7'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-md-5'>
        <div class="form-group">
             <input  style="margin-bottom: 10px: " name="temperatura_dia" class="temperatura_dia" type="number">
        </div>
    </div>


   
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
        <br />
        
        <br />
      <button type="button" onclick="enviar_dia()"  class="enviar_dia btn btn-default">Agregar dia</button>

                </div>  
                  <h3> Fechas Termo</h3>
    <table style="background: white" class="table">
  <thead>
    <tr>
      <th scope="col">Fecha Inicio</th>
      <th scope="col">Fecha final</th>
      <th scope="col">Temperatura</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>        
            </div>
        </div>
    </div>
      
</div>    
</body>
</html>
<script>

// variables 
var TemperaturaReal = 0;
var TemperaturaDeseada = 0;
var Modo = "Automatico";
var Estado = "Conectando";



$(document).ready(function(){ 
    // FECHA Y HORA
    var myLoop = setInterval(function(){
        dateTimer();
        $("#temperatura").text("Temperatura: "+ TemperaturaReal +"ºC");
        $("#temperaturaDeseada").text("Temperatura Deseada: "+ TemperaturaDeseada +"ºC");
        $("#modo").text("Modo :     " + Modo);
        $("#estado").text("Estado :     " + Estado);
    }, 500);
    
});

function addZero(i){
    if(i < 10){
        i = "0" + i;
    }
    
    return i;
}

;                                        

function subtractTime(d, n){
    var d2 = new Date(d.getTime() - (n*60000));
    
    var hours = addZero(d2.getHours());
    var minutes = addZero(d2.getMinutes());
    
    return hours + ":" + minutes;
}

function addTime(d, n){
    var d2 = new Date(d.getTime() + (n*60000));
    
    var hours = addZero(d2.getHours());
    var minutes = addZero(d2.getMinutes());
    
    return hours + ":" + minutes;
}

function dateTimer(){
    var d2 = new Date();
    
    var year = d2.getFullYear();
    
    var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec"];
    var month = months[d2.getMonth()];

    var day = addZero(d2.getDate());
    
    var days = ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
    var dayWeek = days[d2.getDay()];
    
    var hours = addZero(d2.getHours());
    var minutes = addZero(d2.getMinutes());

    $("#date").text(dayWeek + " " + day + "-" + month + "-" + year);

    $("#time").text(hours + ":" + minutes + " GMT +1 ");
}

function subirTemp(){
    var msg = "";

            msg = '{"TempFuncion" : "SUBIR"}';

            doit(msg);    
}
function bajarTemp(){
    var msg = "";

            msg = '{"TempFuncion" : "BAJAR"}';

            doit(msg);    
}

function convert(timestamp){

 // Unixtimestamp
 var unixtimestamp = timestamp;

 // Months array
 var months_arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

 // Convert timestamp to milliseconds
 var date = new Date(unixtimestamp*1000);

 // Year
 var year = date.getFullYear();

 // Month
 var month = months_arr[date.getMonth()];

 // Day
 var day = date.getDate();

 // Hours
 var hours = date.getHours();

 // Minutes
 var minutes = "0" + date.getMinutes();

 // Seconds
 var seconds = "0" + date.getSeconds();

 // Display date time in MM-dd-yyyy h:m:s format
 var convdataTime = month+'-'+day+'-'+year+' '+hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
 
 return convdataTime;
 
}

</script>
