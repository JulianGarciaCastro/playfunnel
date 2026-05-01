
<table id="table_emails" class="tabla-correos w-100">
      <thead>
          <tr>
<!-- 
              <th class="Tth">Nombre</th>
              <th class="Tth">Email</th>
-->
              <th class="Tth">ID</th>
              <th class="Tth">Respuesta<!-- CUEPOINT NAME --></th>
              <th class="Tth">Actividad</th>
              <th class="Tth"></th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td class="Ttd">1</td>
              <td class="Ttd">Product_shoes_running...</td>
              <td class="Ttd">Completa</td>
              <td class="Ttd">...</td>
          </tr>
          <tr>
              <td class="Ttd">2</td>
              <td class="Ttd">Product_shoes_running...</td>
              <td class="Ttd">Completa</td>
              <td class="Ttd">...</td>
          </tr>
          <tr>
              <td class="Ttd">3</td>
              <td class="Ttd">Product_shoes_running...</td>
              <td class="Ttd">Completa</td>
              <td class="Ttd">...</td>
          </tr>
    
      </tbody>
    </table>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
    let table = new DataTable('#table_emails', {
      "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
          /* //cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json */
      }
    });
    </script>
    </div>