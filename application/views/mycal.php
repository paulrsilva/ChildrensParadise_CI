<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html
    <head>
        <meta charset="UTF-8">
        <title>Calendario Children's Paradise</title>
        
        <style type="text/css">
            .calendar {
                font-family: Arial; font-size:14px;
            }
            table.calendar {
                margin: auto; border-collapse: collapse;
            }
            .calendar .days td{
                width: 80px; height: 50px; padding: 4px; 
                border: 1px solid #999;
                vertical-align: top;
                background-color: #DEF; 
            }
            .calendar .days td:hover{
                background-color: #FFF;
            }
            .calendar .highlight {
                font-weight: bold; color: #00F;
            }
            
        </style>
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <script type="text/javascript">
             $(document).ready(function(){
                 $('#btTeste').click(function(){
                     var email = $('#email').val();
                     //alert(email);
                     $.ajax({
                         type:'POST',
                         data: {email: email},
                         url:'<?php echo ci_site_url('/ci/index.php/childrens/teste'); ?>',
                         success: function(result){
                           $('#result1').html(result);
                       }
                     });
                 });
             });
        </script>  
        
    </head>
    <body>
        <?php
        echo $calendar;
        ?>
        <span id="result2"></span>
        <?php echo $ano." - ".$mes; ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $(' .calendar .day').click(function() {
                    day_num = $(this).find('.day_num').html();
                    day_data = prompt('agende o evento', $(this).find('.content').html());
                    if (day_data !== null){
                        alert("<?php echo base_url();?>");
                        $.ajax({
                          data: {
                              dia: day_num,
                              mes: "<?php echo $mes; ?>",
                              ano: "<?php echo $ano; ?>",
                              data: day_data
                          },
                          type: 'POST',
                          url: '<?php echo ci_site_url('/ci/index.php/childrens/index'); ?>',
                          success: function(result) {
                              alert("Save Complete");
                              $('#result2').html(result);
                              //location.reload();
                          }
                        });
                    }
                })
            });
        </script>
        
       
        
        <!--
            var uf_cidades = iduf.value;
            document.location=('./finalizaCadastro/' + uf_cidades); 
        http://www.eventosbacacheri.com.br/eventos/ci/
        -->
        <div>
            <form action="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/index" method="post">
                   <p>Your name: <input type="text" name="name" /></p>
                   <p>Your age: <input type="text" name="age" /></p>
                   <p><input type="submit" /></p>
            </form>
        </div>
        
        <div>
            email <input type="text" id="email">
            <button type="button" value="teste" id="btTeste">teste</button>
            <span id="result1"></span>
            <p></p>
            
            
            
            <!--
            <script type="text/javascript" >
                $(document).ready(function(){
                    dadoTeste="patati";
                    $("button").click(function(){
                        alert(dadoTeste);   
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url();?>/ci/index.php/childrens/index",
                            data: {
                                 day: '05',
                                 data: 'something'
                             },
                            success: function(data) {
                                alert(data);
                                $("p").text(data);

                            }
                        });
               });
            });
            </script>
            -->
            
            
        </div>
    </body>
</html>
                               