<<<<<<< HEAD

<!-- components/lang-on-click-button-event.blade.php -->
<script>
                
                $( document ).ready(function() {

                    /*---------Langs--*/
                    $("#langs-down").click(function() {
                    $("#langs-2 a").each(function(){
                        if(!$(this).hasClass("active")){
                            $(this).toggleClass("d-none");       
                        }else{
                            $(this).parent().prepend($(this));
                        }   
                    });
                    $("#langs-down").toggleClass("rotate"); 
                    });
                });
            
</script>
<!-- components/lang-on-click-button-event.blade.php -->

=======

<!-- components/lang-on-click-button-event.blade.php -->
<script>
                
                $( document ).ready(function() {

                    /*---------Langs--*/
                    $("#langs-down").click(function() {
                    $("#langs-2 a").each(function(){
                        if(!$(this).hasClass("active")){
                            $(this).toggleClass("d-none");       
                        }else{
                            $(this).parent().prepend($(this));
                        }   
                    });
                    $("#langs-down").toggleClass("rotate"); 
                    });
                });
            
</script>
<!-- components/lang-on-click-button-event.blade.php -->

>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
