<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="css/Style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title> {{__('crm.title')}} </title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>

    </head>
	<body class="bg-white">


    	@include('nav_bar')

        @php
            if(app()->getLocale()=='es'){
                $formattedDate = 'Y-m-d h:m:s';
            }else{
                $formattedDate = 'd-m-Y h:m:s';
            }

            $crmCustomFieldTypes = [
                'text' => 'Texto',
                'textarea' => 'Area de texto',
                'email' => 'Email',
                'tel' => 'Telefono',
                'date' => 'Fecha',
                'checkbox' => 'Checkbox',
                'radio' => 'Radio',
            ];

            $crmCustomFieldErrors = $errors->getBag('crmCustomFields');
            $crmTagErrors = $errors->getBag('crmTags');
        @endphp

      {{ csrf_field() }}

        <!--------------------------------MAIN------------------------------->
        <div class="container-fluid m-0 p-0 vh-100">
             <section class="projects row col-12  mx-0 p-0 w-100">
              <!--Menu Side Left -->
              <x-side-nav/>

                <div class="mainContainer col row p-0 m-0">
                    <div class="main w-100 m-0 p-0 p-lg-5 p-2">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h2 class="font-weight-light cMain h3 mb-0">{{__('crm.crm')}}</h2>
                            <div class="d-flex align-items-center mt-3 mt-lg-0">
                                <button
                                    type="button"
                                    class="crm-settings-trigger btn-square-min bg-01 cWhite"
                                    data-toggle="modal"
                                    data-target="#crmTagsModal"
                                    aria-label="Configurar tags CRM"
                                    title="Configurar tags CRM"
                                >
                                    <i class="fas fa-tags cWhite"></i>
                                </button>
                                <button
                                    type="button"
                                    class="crm-settings-trigger btn-square-min bg-Main cWhite ml-2"
                                    data-toggle="modal"
                                    data-target="#crmCustomFieldsModal"
                                    aria-label="Configurar campos personalizados CRM"
                                    title="Configurar campos personalizados CRM"
                                >
                                    <i class="fas fa-cog cWhite"></i>
                                </button>
                            </div>
                        </div>
                      @if (session('crm_custom_fields_success'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('crm_custom_fields_success') }}
                        </div>
                      @endif
                      @if (session('crm_tags_success'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('crm_tags_success') }}
                        </div>
                      @endif
                      @if (session('crm_success'))
                        <div class="alert alert-success mt-3" role="alert">
                            {{ session('crm_success') }}
                        </div>
                      @endif
                      @if ($errors->any() || $crmCustomFieldErrors->any() || $crmTagErrors->any())
                        <div class="alert alert-danger mt-3" role="alert">
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                @foreach ($crmCustomFieldErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                @foreach ($crmTagErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                      @endif
                      <div class="px-2 py-3 my-2 d-flex justify-content-center align-items-center">
                        <div class="col filter d-flex d-lg-none p-3 bg-Main c06 br-r1" ><i class="fas fa-filter"></i></div>
                        <select name="projects" id="projectSelect" class="ml-3 selectBlue">
                        <option value="--"> {{__('crm.all_projects')}} </option>
                        @foreach ($projects as $project)
                            @if ($project->project_status_id == 3)
                              @continue
                            @endif
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                        </select>
                      </div>

                      <div class="col-xl-12 col-lg-12 m-0 mb-4 ml-xl-3 card-dash bg-white emailTable" >
                        <div class="p-3 p-lg-4 border-bottom">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h5 class="cMain mb-1">Columnas visibles</h5>
                                </div>
                                <div class="dropdown mt-2 mt-lg-0">
                                    <button
                                        class="btn-square bg-05 cMain px-3 dropdown-toggle"
                                        type="button"
                                        id="crm-column-picker-toggle"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        Columnas
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right p-3 crm-column-dropdown-menu" aria-labelledby="crm-column-picker-toggle">
                                        <p class="c02 mb-2">Selecciona las columnas que quieres ver.</p>
                                        <div id="crm-column-picker">
                                            @foreach ($crmColumnDefinitions as $column)
                                                <label class="d-flex justify-content-between align-items-center py-1 px-0 m-0">
                                                    <span class="cMain pr-3">{{ $column['label'] }}</span>
                                                    <input
                                                        type="checkbox"
                                                        class="crm-column-toggle"
                                                        value="{{ $column['key'] }}"
                                                        {{ in_array($column['key'], $crmVisibleColumns, true) ? 'checked' : '' }}
                                                    >
                                                </label>
                                            @endforeach
                                        </div>
                                        <hr class="my-2">
                                        <p id="crm-columns-status" class="c02 mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- =================   TABLE - START  ================= -->
                        <div id="interactionTableDataContent" class="crm-table-scroll">
                        <table id="table_emails" class="tabla-correos w-100">
                              <thead>
                                  <tr>
                                      @foreach ($crmColumnDefinitions as $column)
                                      <th class="Tth" data-column-key="{{ $column['key'] }}">{{ $column['label'] }}</th>
                                      @endforeach
                                      <th class="Tth"></th>
                                  </tr>
                              </thead>
                              <tbody id="table-content">

                                  @foreach($crmTableRows as $row)
                                  <tr>
                                      @foreach ($crmColumnDefinitions as $column)
                                          @if ($column['key'] === 'row_number')
                                              <td class="Ttd">{{ $row['row_number'] }}</td>
                                          @elseif ($column['key'] === 'country')
                                              @php
                                                  $countryCode = $row['country'] ?? null;
                                              @endphp
                                              @if ($countryCode)
                                                  <td class="Ttd"><img src="https://flagicons.lipis.dev/flags/4x3/{{ strtolower($countryCode) }}.svg" width="20px"></td>
                                              @else
                                                  <td class="Ttd"></td>
                                              @endif
                                          @elseif ($column['key'] === 'created_at')
                                              <td class="Ttd">{{ !empty($row['created_at']) ? date($formattedDate, strtotime($row['created_at'])) : '' }}</td>
                                          @else
                                              <td class="Ttd">{{ $row[$column['key']] ?? '' }}</td>
                                          @endif
                                      @endforeach
                                      <td class="Ttd">
                                          <div class="dropdown">
                                              <a
                                                  class="btn btn-link p-0 text-dark"
                                                  href="#"
                                                  role="button"
                                                  id="crmActions{{ $row['id'] }}"
                                                  data-toggle="dropdown"
                                                  aria-haspopup="true"
                                                  aria-expanded="false"
                                              >...</a>
                                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="crmActions{{ $row['id'] }}">
                                                  <a class="dropdown-item" href="#" onclick="editCustomerById({{ $row['id'] }}); return false;">{{ __('crm.edit') }}</a>
                                                  <a class="dropdown-item" href="#" onclick="viewCustomerById({{ $row['id'] }}); return false;">{{ __('crm.view_interactions') }}</a>
                                                  <a class="dropdown-item text-danger" href="#" onclick="deleteCustomerById({{ $row['id'] }}); return false;">{{ __('crm.delete') }}</a>
                                              </div>
                                          </div>
                                      </td>
                                  </tr>
                                  @endforeach
                              </tbody>
                            </table>
                            </div>

                            <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.flash.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
                            <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

                            <script>
                            const crmColumnDefinitions = @json($crmColumnDefinitions);
                            let crmVisibleColumns = @json($crmVisibleColumns);
                            let table = null;

                            const updateCrmColumnToggleLabel = (visibleColumns) => {
                                const button = document.querySelector('#crm-column-picker-toggle');
                                if (!button) {
                                    return;
                                }

                                button.textContent = 'Columnas (' + visibleColumns.length + ')';
                            }

                            const updateCrmColumnsStatus = (message, isError = false) => {
                                const status = document.querySelector('#crm-columns-status');
                                if (!status) {
                                    return;
                                }

                                status.textContent = message || '';
                                status.classList.toggle('text-danger', !!isError);
                                status.classList.toggle('c02', !isError);
                            }

                            const getSelectedCrmColumns = () => {
                                return Array.from(document.querySelectorAll('.crm-column-toggle:checked')).map((input) => input.value);
                            }

                            const syncCrmColumnCheckboxes = (visibleColumns) => {
                                document.querySelectorAll('.crm-column-toggle').forEach((input) => {
                                    input.checked = visibleColumns.includes(input.value);
                                });
                                updateCrmColumnToggleLabel(visibleColumns);
                            }

                            const applyCrmColumnVisibility = (visibleColumns) => {
                                if (!table) {
                                    return;
                                }

                                const visibleSet = new Set(visibleColumns);
                                crmColumnDefinitions.forEach((column, index) => {
                                    table.column(index).visible(visibleSet.has(column.key), false);
                                });
                                table.columns.adjust().draw(false);
                            }

                            const saveCrmVisibleColumns = (visibleColumns) => {
                                var form = new FormData();
                                form.append('_token', $("input[name=_token]").val());
                                visibleColumns.forEach((column) => {
                                    form.append('columns[]', column);
                                });

                                $.ajax({
                                    url: '{{ route('crm.visible-columns.save') }}',
                                    type: 'POST',
                                    data: form,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success === 'Y') {
                                            crmVisibleColumns = response.columns || visibleColumns;
                                            syncCrmColumnCheckboxes(crmVisibleColumns);
                                            updateCrmColumnsStatus('Preferencias guardadas.');
                                        }
                                    },
                                    error: function() {
                                        updateCrmColumnsStatus('No se pudieron guardar las preferencias.', true);
                                    }
                                });
                            }

                            const renderCustomerCell = (columnKey, element, index) => {
                                const fieldValue = document.createElement("td");
                                fieldValue.classList.add('Ttd');

                                if (columnKey === 'row_number') {
                                    fieldValue.textContent = index + 1;
                                    return fieldValue;
                                }

                                if (columnKey === 'country') {
                                    const countryCode = element.country || element.contry || '';
                                    if (countryCode) {
                                        const image = document.createElement('img');
                                        image.src = 'https://flagicons.lipis.dev/flags/4x3/' + String(countryCode).toLowerCase() + '.svg';
                                        image.width = 20;
                                        fieldValue.append(image);
                                    }
                                    return fieldValue;
                                }

                                if (columnKey === 'created_at') {
                                    fieldValue.textContent = formatDate(element.created_at);
                                    return fieldValue;
                                }

                                const value = element[columnKey];
                                fieldValue.textContent = (value === null || value === undefined) ? '' : value;
                                return fieldValue;
                            }

                            const initCustomerTable = () => {
                                table = new DataTable('#table_emails', {
                                    dom: 'Bfrtip',
                                    buttons: [
                                        'csv', 'print'
                                    ],
                                    columnDefs: [
                                        {
                                            targets: crmColumnDefinitions.length,
                                            orderable: false,
                                            searchable: false
                                        }
                                    ],
                                  @if(app()->getLocale()=='es')
                                    "language": {
                                        "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                                    }
                                  @endif

                                });

                                applyCrmColumnVisibility(crmVisibleColumns);
                            }

                            initCustomerTable();
                            syncCrmColumnCheckboxes(crmVisibleColumns);

                            $(document).on('click', '.crm-column-dropdown-menu', function(event) {
                                event.stopPropagation();
                            });

                            $(document).on('change', '.crm-column-toggle', function() {
                                const selectedColumns = getSelectedCrmColumns();

                                if (!selectedColumns.length) {
                                    $(this).prop('checked', true);
                                    updateCrmColumnsStatus('Selecciona al menos una columna.', true);
                                    return;
                                }

                                crmVisibleColumns = selectedColumns;
                                applyCrmColumnVisibility(crmVisibleColumns);
                                saveCrmVisibleColumns(crmVisibleColumns);
                            });



                            </script>
                            </div>
                        <!-- =================   TABLE - END  ================= -->


                      </div>
                    </div>
                </div>
             </section>
       	</div>

        <div class="modal fade" id="crmTagsModal" tabindex="-1" role="dialog" aria-labelledby="crmTagsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg crm-custom-fields-dialog" role="document">
                <div class="modal-content crm-custom-fields-modal">
                    <div class="modal-header border-0 align-items-start">
                        <div class="pr-4">
                            <h5 class="modal-title cMain" id="crmTagsModalLabel">Tags CRM</h5>
                            <p class="c02 mb-0">Crea tags para usarlos en widgets de Navegacion y Opciones, sin mezclarlo con los campos del formulario.</p>
                        </div>
                        <button type="button" class="close cMain" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-dash bg-white crm-custom-fields-panel">
                            <div class="crm-custom-fields-block">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                                    <div class="pr-4">
                                        <h5 class="cMain mb-1">Nuevo tag</h5>
                                        <p class="c02 mb-0">Define el nombre y la clave interna del tag.</p>
                                    </div>
                                </div>

                                <form action="{{ route('crm.tags.store') }}" method="POST" class="crm-custom-field-form">
                                    @csrf
                                    <div class="row mx-0 align-items-end">
                                        <div class="col-12 col-lg-5 px-0 pr-lg-3 mb-3 mb-lg-0">
                                            <label class="cMain d-block mb-2" for="crm-tag-name">Nombre</label>
                                            <input
                                                id="crm-tag-name"
                                                type="text"
                                                name="name"
                                                class="inputBlue w-100"
                                                value="{{ old('name') }}"
                                                placeholder="Interes Alto"
                                                maxlength="120"
                                                required
                                            >
                                        </div>
                                        <div class="col-12 col-lg-5 px-0 px-lg-3 mb-3 mb-lg-0">
                                            <label class="cMain d-block mb-2" for="crm-tag-slug">Clave interna</label>
                                            <input
                                                id="crm-tag-slug"
                                                type="text"
                                                name="slug"
                                                class="inputBlue w-100"
                                                value="{{ old('slug') }}"
                                                placeholder="interes_alto"
                                                maxlength="120"
                                            >
                                        </div>
                                        <div class="col-12 col-lg-2 px-0 pl-lg-3 d-flex justify-content-lg-end">
                                            <button type="submit" class="btn-square-min bg-Main cWhite crm-custom-field-action-btn" title="Crear tag">
                                                <i class="fas fa-plus cWhite" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="crm-custom-fields-list mt-4 pt-4">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                                    <div class="pr-4">
                                        <h5 class="cMain mb-1">Tags creados</h5>
                                        <p class="c02 mb-0">Puedes renombrarlos o eliminarlos cuando ya no los necesites.</p>
                                    </div>
                                </div>

                                @forelse ($crmTags as $tag)
                                    <div class="crm-custom-field-item">
                                        <div class="crm-custom-field-item-body">
                                            <form
                                                id="crm-tag-edit-{{ $tag->id }}"
                                                action="{{ route('crm.tags.update', $tag->id) }}"
                                                method="POST"
                                                class="crm-custom-field-form crm-custom-field-edit-form"
                                            >
                                                @csrf
                                                @method('PUT')
                                                <div class="row mx-0 align-items-end">
                                                    <div class="col-12 col-lg-5 px-0 pr-lg-3 mb-3 mb-lg-0">
                                                        <label class="cMain d-block mb-2">Nombre</label>
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="inputBlue w-100"
                                                            value="{{ $tag->name }}"
                                                            maxlength="120"
                                                            required
                                                        >
                                                    </div>
                                                    <div class="col-12 col-lg-5 px-0 px-lg-3 mb-3 mb-lg-0">
                                                        <label class="cMain d-block mb-2">Clave interna</label>
                                                        <input
                                                            type="text"
                                                            name="slug"
                                                            class="inputBlue w-100"
                                                            value="{{ $tag->slug }}"
                                                            maxlength="120"
                                                        >
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="crm-custom-field-actions">
                                                <button type="submit" form="crm-tag-edit-{{ $tag->id }}" class="btn-square-min bg-01 cWhite crm-custom-field-action-btn" title="Guardar cambios">
                                                    <i class="fas fa-save cWhite" aria-hidden="true"></i>
                                                </button>
                                                <form action="{{ route('crm.tags.destroy', $tag->id) }}" method="POST" class="crm-custom-field-delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn-square-min bg-03 cWhite crm-custom-field-action-btn"
                                                        title="Eliminar tag"
                                                        onclick="return confirm('¿Quieres eliminar este tag?');"
                                                    >
                                                        <i class="fas fa-trash-alt cWhite" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="crm-custom-fields-empty bg-05 c02">
                                        Todavia no has creado tags CRM.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crmCustomFieldsModal" tabindex="-1" role="dialog" aria-labelledby="crmCustomFieldsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl crm-custom-fields-dialog" role="document">
                <div class="modal-content crm-custom-fields-modal">
                    <div class="modal-header border-0 align-items-start">
                        <div class="pr-4">
                            <h5 class="modal-title cMain" id="crmCustomFieldsModalLabel">Campos personalizados CRM</h5>
                            <p class="c02 mb-0">Crea y edita campos para guardar datos del formulario dentro del CRM.</p>
                        </div>
                        <button type="button" class="close cMain" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-dash bg-white crm-custom-fields-panel">
                            <div class="crm-custom-fields-block">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                                    <div class="pr-4">
                                        <h5 class="cMain mb-1">Nuevo campo</h5>
                                        <p class="c02 mb-0">Define el nombre, la clave interna y el tipo del dato que quieres guardar en el CRM.</p>
                                    </div>
                                </div>

                                <form action="{{ route('crm.custom-fields.store') }}" method="POST" class="crm-custom-field-form">
                                    @csrf
                                    <div class="row mx-0 align-items-end">
                                        <div class="col-12 col-lg-4 px-0 pr-lg-3 mb-3 mb-lg-0">
                                            <label class="cMain d-block mb-2" for="crm-custom-field-name">Nombre</label>
                                            <input
                                                id="crm-custom-field-name"
                                                type="text"
                                                name="name"
                                                class="inputBlue w-100"
                                                value="{{ old('name') }}"
                                                placeholder="Empresa"
                                                maxlength="120"
                                                required
                                            >
                                        </div>
                                        <div class="col-12 col-lg-4 px-0 px-lg-3 mb-3 mb-lg-0">
                                            <label class="cMain d-block mb-2" for="crm-custom-field-slug">Clave interna</label>
                                            <input
                                                id="crm-custom-field-slug"
                                                type="text"
                                                name="slug"
                                                class="inputBlue w-100"
                                                value="{{ old('slug') }}"
                                                placeholder="empresa"
                                                maxlength="120"
                                            >
                                        </div>
                                        <div class="col-12 col-lg-3 px-0 px-lg-3 mb-3 mb-lg-0">
                                            <label class="cMain d-block mb-2" for="crm-custom-field-type">Tipo</label>
                                            <select id="crm-custom-field-type" name="type" class="selectBlue w-100">
                                                @foreach ($crmCustomFieldTypes as $typeValue => $typeLabel)
                                                    <option value="{{ $typeValue }}" {{ old('type', 'text') === $typeValue ? 'selected' : '' }}>
                                                        {{ $typeLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-1 px-0 pl-lg-3 d-flex justify-content-lg-end">
                                            <button type="submit" class="btn-square-min bg-Main cWhite crm-custom-field-action-btn" title="Crear campo">
                                                <i class="fas fa-plus cWhite" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="crm-custom-fields-list mt-4 pt-4">
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                                    <div class="pr-4">
                                        <h5 class="cMain mb-1">Campos creados</h5>
                                        <p class="c02 mb-0">Puedes renombrarlos, cambiar su tipo o eliminarlos cuando ya no los necesites.</p>
                                    </div>
                                </div>

                                @forelse ($crmCustomFields as $customField)
                                    <div class="crm-custom-field-item">
                                        <div class="crm-custom-field-item-body">
                                            <form
                                                id="crm-custom-field-edit-{{ $customField->id }}"
                                                action="{{ route('crm.custom-fields.update', $customField->id) }}"
                                                method="POST"
                                                class="crm-custom-field-form crm-custom-field-edit-form"
                                            >
                                                @csrf
                                                @method('PUT')
                                                <div class="row mx-0 align-items-end">
                                                    <div class="col-12 col-lg-4 px-0 pr-lg-3 mb-3 mb-lg-0">
                                                        <label class="cMain d-block mb-2">Nombre</label>
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="inputBlue w-100"
                                                            value="{{ $customField->name }}"
                                                            maxlength="120"
                                                            required
                                                        >
                                                    </div>
                                                    <div class="col-12 col-lg-4 px-0 px-lg-3 mb-3 mb-lg-0">
                                                        <label class="cMain d-block mb-2">Clave interna</label>
                                                        <input
                                                            type="text"
                                                            name="slug"
                                                            class="inputBlue w-100"
                                                            value="{{ $customField->slug }}"
                                                            maxlength="120"
                                                        >
                                                    </div>
                                                    <div class="col-12 col-lg-4 px-0 pl-lg-3">
                                                        <label class="cMain d-block mb-2">Tipo</label>
                                                        <select name="type" class="selectBlue w-100">
                                                            @foreach ($crmCustomFieldTypes as $typeValue => $typeLabel)
                                                                <option value="{{ $typeValue }}" {{ ($customField->type ?? 'text') === $typeValue ? 'selected' : '' }}>
                                                                    {{ $typeLabel }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="crm-custom-field-actions">
                                                <button type="submit" form="crm-custom-field-edit-{{ $customField->id }}" class="btn-square-min bg-01 cWhite crm-custom-field-action-btn" title="Guardar cambios">
                                                    <i class="fas fa-save cWhite" aria-hidden="true"></i>
                                                </button>
                                                <form action="{{ route('crm.custom-fields.destroy', $customField->id) }}" method="POST" class="crm-custom-field-delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn-square-min bg-03 cWhite crm-custom-field-action-btn"
                                                        title="Eliminar campo"
                                                        onclick="return confirm('Se eliminaran tambien los valores guardados de este campo. ¿Quieres continuar?');"
                                                    >
                                                        <i class="fas fa-trash-alt cWhite" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="crm-custom-fields-empty bg-05 c02">
                                        Todavia no has creado campos personalizados CRM.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crmEditCustomerModal" tabindex="-1" role="dialog" aria-labelledby="crmEditCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title cMain" id="crmEditCustomerModalLabel">{{ __('crm.edit') }} CRM</h5>
                        <button type="button" class="close cMain" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="crm-edit-customer-id">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="crm-edit-name">{{ __('crm.name') }}</label>
                                <input type="text" class="form-control" id="crm-edit-name" maxlength="255">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="crm-edit-email">Email</label>
                                <input type="email" class="form-control" id="crm-edit-email" maxlength="255">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="crm-edit-tel">{{ __('crm.phone') }}</label>
                                <input type="text" class="form-control" id="crm-edit-tel" maxlength="20">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="crm-edit-birthday">{{ __('crm.birthday') }}</label>
                                <input type="date" class="form-control" id="crm-edit-birthday">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="crm-edit-address">{{ __('crm.address') }}</label>
                                <input type="text" class="form-control" id="crm-edit-address" maxlength="255">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="crm-edit-city">{{ __('crm.city') }}</label>
                                <input type="text" class="form-control" id="crm-edit-city" maxlength="50">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="crm-edit-state">{{ __('crm.state') }}</label>
                                <input type="text" class="form-control" id="crm-edit-state" maxlength="50">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="crm-edit-cp">{{ __('crm.zip') }}</label>
                                <input type="text" class="form-control" id="crm-edit-cp" maxlength="10">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="crm-edit-country">{{ __('crm.country') }}</label>
                                <input type="text" class="form-control" id="crm-edit-country" maxlength="50">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="crm-edit-tags">{{ __('crm.tags') }}</label>
                                <input type="text" class="form-control" id="crm-edit-tags" maxlength="500" placeholder="vip, interes_alto, seguimiento">
                            </div>
                        </div>

                        <hr>
                        <h6 class="cMain mb-3">Campos personalizados</h6>
                        <div id="crm-edit-custom-fields" class="row"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('crm.cancel') }}</button>
                        <button type="button" class="btn bg-Main cWhite" onclick="saveCustomerEdition()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Histórico de interacciones -->
         <div class="modal fade bd-example-modal-md show" id="interactionsFilterByCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="close-modal"><a onclick="closeModal()"><i class="fas fa-times" aria-hidden="true"></i></a></div>
                <div class="modal-content justify-content-start col-12 p-4" id="viewCustomer">

                </div>
              </div>
            </div>
          </div>




        <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

          <!-- Chart.js -->
          <script src="lib/Chart.js-3.6.2/chart.min.js"></script>
        <script>
            $(function() {
                const shouldOpenCrmCustomFieldsModal = @json(session('crm_custom_fields_success') || $crmCustomFieldErrors->any() || session('crm_success'));
                const shouldOpenCrmTagsModal = @json(session('crm_tags_success') || $crmTagErrors->any());

                if (shouldOpenCrmTagsModal) {
                    $('#crmTagsModal').modal('show');
                } else if (shouldOpenCrmCustomFieldsModal) {
                    $('#crmCustomFieldsModal').modal('show');
                }
            });

            const CRM_TEXT_EDIT = @json(__('crm.edit'));
            const CRM_TEXT_VIEW_INTERACTIONS = @json(__('crm.view_interactions'));
            const CRM_TEXT_DELETE = @json(__('crm.delete'));
            const CRM_TEXT_CONFIRM_DELETE = @json(__('crm.confirm_delete'));
            const CRM_TEXT_DELETE_ERROR = @json(__('crm.delete_error'));
            const CRM_TEXT_UPDATE_ERROR = 'No se pudo actualizar el registro.';

            //If select other project
            $( "#projectSelect" ).change(function() {
                if($(this).val() == '--'){
                    window.location.reload();
                }else{
                    reloadDate();
                }

            });

            //Call customers by Project
            function reloadDate(){

                var form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('projectId',$("#projectSelect").val());
                console.log("los datos son: projectSelect = "+$("#projectSelect").val())
                //console.log("los datos son: ID:"+projectId+", Dispositivo:"+device+", Tiempo:"+dates+", Fecha inicio:"+dateStart+", Fecha Fin:"+dateEnd);

                $.ajax({
                	url:    'crm-CustomerByProjectId',
                    type:   'POST',
                    data:   form,
                    cache:  false,
            		contentType: false, // 'application/json; charset=utf-8'
            		processData: false,
             		dataType: 'json' ,
                    success: function(response){
                            if(response.success == 'Y') {
                            // Reinicializar el DataTable
                            console.log(response.customers);
                            createTable(response.customers);
                            }
                      		if(response.success == 'N') {
                      			alert("Error: " + response.message);
                      		}
                    },
                    error: function(request, error){
            				  console.log(error);
            				  alert("Error: "+JSON.stringify(error));
            		}
                });
            }

            const buildActionsDropdown = (customerId) => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('dropdown');

                const toggle = document.createElement('a');
                toggle.classList.add('btn', 'btn-link', 'p-0', 'text-dark');
                toggle.href = '#';
                toggle.setAttribute('role', 'button');
                toggle.setAttribute('data-toggle', 'dropdown');
                toggle.setAttribute('aria-haspopup', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.textContent = '...';

                const menu = document.createElement('div');
                menu.classList.add('dropdown-menu', 'dropdown-menu-right');

                const editOption = document.createElement('a');
                editOption.classList.add('dropdown-item');
                editOption.href = '#';
                editOption.textContent = CRM_TEXT_EDIT;
                editOption.addEventListener('click', function(event) {
                    event.preventDefault();
                    editCustomerById(customerId);
                });

                const viewOption = document.createElement('a');
                viewOption.classList.add('dropdown-item');
                viewOption.href = '#';
                viewOption.textContent = CRM_TEXT_VIEW_INTERACTIONS;
                viewOption.addEventListener('click', function(event) {
                    event.preventDefault();
                    viewCustomerById(customerId);
                });

                const deleteOption = document.createElement('a');
                deleteOption.classList.add('dropdown-item', 'text-danger');
                deleteOption.href = '#';
                deleteOption.textContent = CRM_TEXT_DELETE;
                deleteOption.addEventListener('click', function(event) {
                    event.preventDefault();
                    deleteCustomerById(customerId);
                });

                menu.append(editOption, viewOption, deleteOption);
                wrapper.append(toggle, menu);

                return wrapper;
            }

            function deleteCustomerById(customerId) {
                if (!confirm(CRM_TEXT_CONFIRM_DELETE)) {
                    return;
                }

                var form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('CustomerId', customerId);

                $.ajax({
                    url: 'crm-delete-customer',
                    type: 'POST',
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if(response.success == 'Y') {
                            if($("#projectSelect").val() == '--'){
                                window.location.reload();
                            } else {
                                reloadDate();
                            }
                        }
                        if(response.success == 'N') {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(request, error){
                        console.log(error);
                        alert("Error: " + CRM_TEXT_DELETE_ERROR);
                    }
                });
            }

            //Call Re-build table customers by Project
            const createTable = (customers) =>{
                if (table) {
                    table.destroy();
                    table = null;
                }

                document.querySelector('#table-content').remove();
                const newContent = document.createElement("tbody");
                newContent.setAttribute('id','table-content');
                document.querySelector('#table_emails').append(newContent);

                customers.forEach((element, index) => {
                    const fieldCustomer = document.createElement("tr");
                    crmColumnDefinitions.forEach((column) => {
                        fieldCustomer.append(renderCustomerCell(column.key, element, index));
                    });

                    const actionCell = document.createElement("td");
                    actionCell.classList.add('Ttd');
                    actionCell.append(buildActionsDropdown(element.id));
                    fieldCustomer.append(actionCell);

                    document.querySelector('#table-content').append(fieldCustomer);
                });

                initCustomerTable();
            }

            //Change format to date from ISO to yyyy-mm-dd hh:mm:ss
            const formatDate = ( date ) => {
                const fechaOriginal = date;
                const fechaObjeto = new Date(fechaOriginal);

                const anio = fechaObjeto.getUTCFullYear();
                const mes = fechaObjeto.getUTCMonth() + 1; // Los meses en JavaScript son base 0 (enero = 0)
                const dia = fechaObjeto.getUTCDate();
                const hora = fechaObjeto.getUTCHours();
                const minutos = fechaObjeto.getUTCMinutes();
                const segundos = fechaObjeto.getUTCSeconds();

                // Formatea la cadena de fecha deseada

                //console.log(fechaFormateada);



                @if(app()->getLocale()=='es')
                const fechaFormateada = `${anio}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')} ${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
                @else
                const fechaFormateada = `${dia.toString().padStart(2, '0')}-${mes.toString().padStart(2, '0')}-${anio} ${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
                @endif
                console.log(fechaFormateada);
                return  fechaFormateada;
            }

            const formatCustomFieldValue = (value) => {
                if (Array.isArray(value)) {
                    return value.length ? value.join(', ') : '--';
                }

                if (value === true) {
                    return 'Si';
                }

                if (value === false || value === null || value === undefined || value === '') {
                    return '--';
                }

                return value;
            }

            const normalizeTextValue = (value) => {
                if (value === null || value === undefined) {
                    return '';
                }

                return String(value).trim();
            }

            const normalizeDateValue = (value) => {
                if (!value) {
                    return '';
                }

                const raw = String(value).trim();
                if (raw.length >= 10) {
                    return raw.substring(0, 10);
                }

                return '';
            }

            const getCustomFieldEditValue = (field) => {
                const type = String(field.type || 'text').toLowerCase();
                const value = field.value;

                if (type === 'checkbox') {
                    if (value === true || value === 1 || value === '1') {
                        return '1';
                    }
                    if (value === false || value === 0 || value === '0') {
                        return '0';
                    }
                    return '';
                }

                if (type === 'date') {
                    return normalizeDateValue(value);
                }

                if (Array.isArray(value)) {
                    return value.join(', ');
                }

                if (value === null || value === undefined) {
                    return '';
                }

                return String(value);
            }

            const renderEditCustomFields = (customFields) => {
                const container = document.querySelector('#crm-edit-custom-fields');
                if (!container) {
                    return;
                }

                container.innerHTML = '';

                if (!Array.isArray(customFields) || !customFields.length) {
                    const empty = document.createElement('div');
                    empty.classList.add('col-12', 'c02');
                    empty.textContent = 'No hay campos personalizados creados.';
                    container.append(empty);
                    return;
                }

                customFields.forEach((field) => {
                    const fieldType = String(field.type || 'text').toLowerCase();
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('col-12', 'col-md-6', 'mb-3');

                    const label = document.createElement('label');
                    label.classList.add('d-block', 'mb-2', 'cMain');
                    label.textContent = field.name || ('Campo #' + field.id);
                    wrapper.append(label);

                    let input = null;
                    if (fieldType === 'textarea') {
                        input = document.createElement('textarea');
                        input.rows = 3;
                    } else if (fieldType === 'checkbox') {
                        input = document.createElement('select');
                        const options = [
                            { value: '', text: 'Sin valor' },
                            { value: '1', text: 'Si' },
                            { value: '0', text: 'No' },
                        ];
                        options.forEach((opt) => {
                            const option = document.createElement('option');
                            option.value = opt.value;
                            option.textContent = opt.text;
                            input.append(option);
                        });
                    } else {
                        input = document.createElement('input');
                        input.type = (fieldType === 'email' || fieldType === 'tel' || fieldType === 'date') ? fieldType : 'text';
                    }

                    input.classList.add('form-control', 'crm-edit-custom-field');
                    input.setAttribute('data-field-id', String(field.id || ''));
                    input.setAttribute('data-field-type', fieldType);
                    input.value = getCustomFieldEditValue(field);

                    wrapper.append(input);
                    container.append(wrapper);
                });
            }

            const fetchCustomerById = (customerId, onSuccess) => {
                var form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('CustomerId', customerId);

                $.ajax({
                    url: 'crm-CustomerById',
                    type: 'POST',
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if(response.success == 'Y') {
                            onSuccess(response);
                            return;
                        }
                        if(response.success == 'N') {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(request, error){
                        console.log(error);
                        alert("Error: "+JSON.stringify(error));
                    }
                });
            }

            function editCustomerById(customerId) {
                fetchCustomerById(customerId, function(response) {
                    const customer = response.customers || {};
                    $('#crm-edit-customer-id').val(customer.id || customerId);
                    $('#crm-edit-name').val(normalizeTextValue(customer.name));
                    $('#crm-edit-email').val(normalizeTextValue(customer.email));
                    $('#crm-edit-tel').val(normalizeTextValue(customer.tel));
                    $('#crm-edit-address').val(normalizeTextValue(customer.address));
                    $('#crm-edit-birthday').val(normalizeDateValue(customer.birthday));
                    $('#crm-edit-city').val(normalizeTextValue(customer.city));
                    $('#crm-edit-state').val(normalizeTextValue(customer.state));
                    $('#crm-edit-cp').val(normalizeTextValue(customer.cp));
                    $('#crm-edit-country').val(normalizeTextValue(customer.country || customer.contry));
                    $('#crm-edit-tags').val(normalizeTextValue(customer.tags));

                    renderEditCustomFields(response.custom_fields || []);
                    $('#crmEditCustomerModal').modal('show');
                });
            }

            const collectCustomFieldsEditionPayload = () => {
                const payload = [];

                document.querySelectorAll('.crm-edit-custom-field').forEach((fieldInput) => {
                    const fieldId = parseInt(fieldInput.getAttribute('data-field-id'), 10);
                    const fieldType = String(fieldInput.getAttribute('data-field-type') || 'text').toLowerCase();
                    if (!fieldId) {
                        return;
                    }

                    let value = fieldInput.value;
                    if (fieldType === 'checkbox') {
                        if (value === '1') {
                            value = true;
                        } else if (value === '0') {
                            value = false;
                        } else {
                            value = null;
                        }
                    } else {
                        value = normalizeTextValue(value);
                        if (value === '') {
                            value = null;
                        }
                    }

                    payload.push({
                        id: fieldId,
                        value: value,
                    });
                });

                return payload;
            }

            function saveCustomerEdition() {
                const customerId = parseInt($('#crm-edit-customer-id').val(), 10);
                if (!customerId) {
                    return;
                }

                const form = new FormData();
                form.append('_token', $("input[name=_token]").val());
                form.append('CustomerId', customerId);
                form.append('name', normalizeTextValue($('#crm-edit-name').val()));
                form.append('email', normalizeTextValue($('#crm-edit-email').val()));
                form.append('tel', normalizeTextValue($('#crm-edit-tel').val()));
                form.append('address', normalizeTextValue($('#crm-edit-address').val()));
                form.append('birthday', normalizeDateValue($('#crm-edit-birthday').val()));
                form.append('city', normalizeTextValue($('#crm-edit-city').val()));
                form.append('state', normalizeTextValue($('#crm-edit-state').val()));
                form.append('cp', normalizeTextValue($('#crm-edit-cp').val()));
                form.append('country', normalizeTextValue($('#crm-edit-country').val()));
                form.append('tags', normalizeTextValue($('#crm-edit-tags').val()));
                form.append('crm_custom_field_data', JSON.stringify(collectCustomFieldsEditionPayload()));

                $.ajax({
                    url: 'crm-update-customer',
                    type: 'POST',
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        if(response.success == 'Y') {
                            $('#crmEditCustomerModal').modal('hide');
                            if($("#projectSelect").val() == '--'){
                                window.location.reload();
                            } else {
                                reloadDate();
                            }
                            return;
                        }

                        if(response.success == 'N') {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(request){
                        const message = request && request.responseJSON && request.responseJSON.message
                            ? request.responseJSON.message
                            : CRM_TEXT_UPDATE_ERROR;
                        alert("Error: " + message);
                    }
                });
            }

            //Press View in Customer
            function viewCustomerById(customerId) {
                fetchCustomerById(customerId, function(response) {
                    createCustomer(response);
                });
            }

            //Build view customers and Interactions
            const createCustomer = (interactions) =>{
                console.log(interactions);
                viewCustomer = document.querySelector('#interactionsFilterByCustomer #viewCustomer');

                //clean modal
                viewCustomer.innerHTML = '';

                //createTable
                const header = document.createElement('div');
                header.classList.add('d-flex');
                const i = document.createElement('i');
                i.classList.add('far','fa-user-circle','mr-4');
                i.setAttribute('aria-hidden','true')
                const title = document.createElement('div');
                const titulo = document.createElement('div');
                const h2 = document.createElement('h2');
                h2.textContent = interactions.customers.name;
                const p = document.createElement('p');
                p.textContent = interactions.customers.email;
                title.append(h2,p);
                header.append(i,title);
                viewCustomer.append(header);

                if (Array.isArray(interactions.custom_fields) && interactions.custom_fields.length) {
                    const fieldsWithValue = interactions.custom_fields.filter((field) => {
                        if (Array.isArray(field.value)) {
                            return field.value.length > 0;
                        }

                        return field.value !== null && field.value !== undefined && field.value !== '';
                    });

                    if (fieldsWithValue.length) {
                        const customFieldsSection = document.createElement('div');
                        customFieldsSection.classList.add('mt-4');

                        const hr = document.createElement('hr');
                        const title = document.createElement('h6');
                        title.classList.add('cMain', 'mb-3');
                        title.textContent = 'Campos personalizados';
                        customFieldsSection.append(hr, title);

                        fieldsWithValue.forEach((field) => {
                            const row = document.createElement('div');
                            row.classList.add('d-flex', 'justify-content-between', 'align-items-start', 'py-2', 'border-bottom');

                            const label = document.createElement('div');
                            label.classList.add('font-weight-bold', 'cMain', 'pr-3');
                            label.textContent = field.name;

                            const value = document.createElement('div');
                            value.classList.add('text-right', 'c02');
                            value.textContent = formatCustomFieldValue(field.value);

                            row.append(label, value);
                            customFieldsSection.append(row);
                        });

                        viewCustomer.append(customFieldsSection);
                    }
                }


                //create Interactions Panels
                let projectsSet = [];
                interactions.iteractions.forEach((element, index) => {
                    //create main container
                    const interactionProject = document.createElement('div');

                    //create hr h4 ul
                    if(!projectsSet.includes(element.projectid)){
                        console.log('create new project ul');
                        const hr = document.createElement('hr');
                        const h6 = document.createElement('h6');
                        h6.textContent = element.nameProject;
                        h6.classList.add('cMain');
                        const ul = document.createElement('ul');
                        ul.setAttribute('data-project',element.projectid);
                        h6.classList.add('p-3');
                        interactionProject.append(hr, h6, ul)
                        viewCustomer.append(interactionProject);
                        projectsSet.push(element.projectid);
                        console.log(projectsSet);
                    }else{
                        console.log('same project ul');
                    }


                    //interactions
                    const li = document.createElement('li');
                    li.classList.add('d-flex','justify-content-between');
                    const route = document.createElement('div');
                    route.classList.add('routeTitle','w-50');
                    const interactionName = element.cuepointoptionname || '';
                    const interactionTag = element.cuepointtag ? ` [${element.cuepointtag}]` : '';
                    route.textContent = interactionName + interactionTag;
                    const date = document.createElement('div');
                    date.classList.add('dateTitle');
                    date.textContent = formatDate(element.created_at);
                    li.append(route, date);
                    const ul = document.querySelector('[data-project="'+element.projectid+'"]');
                    const hr = document.createElement('hr');
                    ul.append(hr, li);
                });

                $('#interactionsFilterByCustomer').modal().show();


            }


            //Close modal
            function closeModal(){
                $('#interactionsFilterByCustomer').modal('hide');
            }


        </script>





    </body>
</html>
