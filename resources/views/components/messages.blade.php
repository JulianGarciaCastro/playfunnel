<!--- Modal Messages --->
<div class="modal fade bd-example-modal-sm" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="col-12">
          <div class="col-12 row justify-content-end p-0 m-0 pt-3">
            <button data-dismiss="modal" aria-label="Close"  type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
              <span class="material-icons d-flex justify-content-center">clear</span>
            </button>
          </div>
          <p class="text-h3 cMain text-center mt-3" id="modalMsgTitle">Mensaje de Sistema</p>
          <p class="text-center pb-2 c02"  id="modalMsgContent">Mensaje a Presentar</p>
          <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
              <button type="button" class="btn-square px-3 bg-Main cWhite" id="msgOK" onclick="modalMsgClose()">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
</div>


<!--- Modal Proyecto --->
<div class="modal fade bd-example-modal-sm" id="ProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
    	<div class="col-12">
    	  <div class="col-12 row justify-content-end p-0 m-0 pt-3">
    		<button data-dismiss="modal" aria-label="Close"  type="submit" class="align-items-center justify-content-center mr-2 btn-square-min bg-03 cWhite">
    		  <span class="material-icons d-flex justify-content-center">clear</span>
    		</button>
    	  </div>
    	  <p class="text-h3 cMain text-center mt-3" id="modalTitle">Eliminar Medio</p>
    	  <p class="text-center pb-2 c02"  id="modalContent">¿Estas seguro que deseas desvincular el medio del proyecto?</p>
    	  <div class="row justify-content-center w-100 p-0 col-12 row m-0 mb-5">
    		  <button type="button" class="btn-square px-3 bg-Main cWhite" id="okBTN" onclick="deleteProjectLibModalBtn()">Confirmar</button>
    		  <button type="button" class="btn-square px-3 bg-05 cMain ml-5" id="cancelBTN"  data-dismiss="modal" >Descartar</button>
    	  </div>
    	</div>
      </div>
    </div>
</div>

<script>

    function modalMsgShow(texto) {
    	$("#modalMsgContent").text(texto);
    	$('#msgModal').modal('show');
    	
    	//setTimeout(
    	//	function(){
        //       $("#msgModal").modal("hide");
        //    }, 2000);
    	
    }

    function modalMsgClose() {
    	$('#msgModal').modal('hide');
    }


    function ProjectModalClose() {
        $('#ProjectModal').modal('hide');
    }


    function ProjectModalSave(checking) {
        if (checking) {
            $("#modalTitle").text("Cambios guardados");
        } else {
            $("#modalTitle").text("No hay cambios disponibles");
        }

        $("#modalContent").hide();
        $("#okBTN").attr("onClick", "ProjectModalClose()")
        $("#okBTN").hide();
        $("#cancelBTN").hide();
        $('#ProjectModal').modal('show');
        setTimeout(
            function() {
                $("#ProjectModal").modal("hide");
            }, 2000);
    }
    
</script>