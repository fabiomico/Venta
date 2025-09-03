<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="container py-4">
                    <h3>Empresas Registradas</h3>

                    <div class="mb-3 row g-2">
                        <div class="col-md-6">
                            <input type="text" id="search" class="form-control" placeholder="Buscar empresa por cualquier campo..." autocomplete="off">
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistrarEmpresa">
                                    <i class="bx bx-plus"></i> Registrar Empresa
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="empresas-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logotipo</th>
                                    <th data-column="nombre">Nombre</th>
                                    <th data-column="telefono">Teléfono</th>
                                    <th data-column="correo">Correo</th>
                                    <th data-column="direccion">Dirección</th>
                                    <th data-column="nit">NIT</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="empresas-body">
                                <tr>
                                    <td colspan="8" class="text-center">Cargando...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <nav>
                        <ul class="pagination justify-content-center" id="empresas-pagination"></ul>
                    </nav>
                </div>

                <!-- Modal registrar empresa -->
                <div class="modal fade" id="modalRegistrarEmpresa" tabindex="-1" aria-labelledby="modalRegistrarEmpresaLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalRegistrarEmpresaLabel">Registrar Empresa</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <form id="formRegistrarEmpresa" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="correo" class="form-label">Correo</label>
                                            <input type="email" class="form-control" id="correo" name="correo">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nit" class="form-label">NIT</label>
                                            <input type="text" class="form-control" id="nit" name="nit">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="logo" class="form-label">Logo (opcional)</label>
                                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal editar empresa -->
                <div class="modal fade" id="modalEditarEmpresa" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form id="formEditarEmpresa" enctype="multipart/form-data">
                                <div class="modal-header ">
                                    <h5 class="modal-title" id="modalEditarEmpresaLabel">Editar Empresa</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="editar-id">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="editar-nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" id="editar-nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" name="telefono" id="editar-telefono">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-correo" class="form-label">Correo</label>
                                            <input type="email" class="form-control" name="correo" id="editar-correo">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" name="direccion" id="editar-direccion">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-nit" class="form-label">NIT</label>
                                            <input type="text" class="form-control" name="nit" id="editar-nit">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-logo" class="form-label">Logo (opcional)</label>
                                            <input type="file" class="form-control" name="logo" id="editar-logo" accept="image/*">
                                            <div id="editPreviewLogo" style="display:none;">
                                                <img id="editLogoPreviewImg" class="img-thumbnail" style="max-height:100px;cursor:pointer">
                                                <button type="button" id="btnQuitarLogoEdit" class="btn btn-sm btn-danger mt-1">Quitar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    const storageBaseUrl = "{{ asset('logos_empresas') }}";
                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {

                        // --- Toast
                        function showToast(message, type = 'primary') {
                            const toastEl = document.querySelector('.bs-toast');
                            toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                            toastEl.querySelector('.toast-body').textContent = message;
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        }

                        // --- Tabla de empresas
                        const tableBody = document.getElementById('empresas-body');
                        const pagination = document.getElementById('empresas-pagination');
                        const searchInput = document.getElementById('search');
                        const tableHeaders = document.querySelectorAll('#empresas-table th[data-column]');

                        let currentPage = 1;
                        let sortColumn = '';
                        let sortDirection = 'asc';
                        let currentSearch = '';

                        function highlight(text, term) {
                            if (!term) return text;
                            return text.replace(new RegExp(`(${term})`, 'gi'), '<mark>$1</mark>');
                        }

                        function fetchEmpresas(page = 1, search = '', sortCol = '', sortDir = '') {
                            fetch(`{{ route('empresa.fetch') }}?page=${page}&search=${search}&sort=${sortCol}&direction=${sortDir}`)
                                .then(res => res.json())
                                .then(data => {
                                    tableBody.innerHTML = '';

                                    if (!data.data || data.data.length === 0) {
                                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No hay empresas registradas</td></tr>';
                                        pagination.innerHTML = '';
                                        return;
                                    }

                                    data.data.forEach((empresa, index) => {
                                        const logoUrl = empresa.logo ? `/storage/${empresa.logo}` : '';

                                        tableBody.innerHTML += `
                    <tr data-id="${empresa.id}" data-logo="${logoUrl}">
                        <td>${highlight(empresa.id, search)}</td>
                        <td>
                            ${logoUrl ? `<img src="${logoUrl}" class="logo-thumb" style="width:50px;height:50px;cursor:pointer" onclick="openLogoPreview('${logoUrl}')">` : '-'}
                        </td>
                        <td>${highlight(empresa.nombre, search)}</td>
                        <td>${highlight(empresa.telefono ?? '-', search)}</td>
                        <td>${highlight(empresa.correo ?? '-', search)}</td>
                        <td>${highlight(empresa.direccion ?? '-', search)}</td>
                        <td>${highlight(empresa.nit ?? '-', search)}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-editar" data-id="${empresa.id}">Editar</button>
                            <button class="btn btn-sm btn-danger btn-eliminar" data-id="${empresa.id}">Eliminar</button>
                        </td>
                    </tr>
                `;
                                    });


                                    // Función para abrir SweetAlert2 al hacer clic en la imagen
                                    function openLogoPreview(url) {
                                        Swal.fire({
                                            imageUrl: url,
                                            imageAlt: 'Logo Empresa',
                                            showConfirmButton: false,
                                            background: '#fff',
                                            width: 'auto',
                                            heightAuto: true,
                                            customClass: {
                                                popup: 'swal-wide'
                                            },
                                            didOpen: () => {
                                                document.querySelector('.swal-wide').style.zIndex = 20000;
                                            }
                                        });
                                    }
                                    // Paginación
                                    const totalPages = data.last_page;
                                    let pagHtml = `<li class="page-item ${data.current_page===1?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                </li>`;
                                    for (let i = 1; i <= totalPages; i++) {
                                        pagHtml += `<li class="page-item ${i===data.current_page?'active':''}">
                        <a href="#" class="page-link" data-page="${i}">${i}</a>
                    </li>`;
                                    }
                                    pagHtml += `<li class="page-item ${data.current_page===totalPages?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                </li>`;
                                    pagination.innerHTML = pagHtml;

                                    document.querySelectorAll('#empresas-pagination a').forEach(a => {
                                        a.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            const page = parseInt(this.dataset.page);
                                            if (page >= 1 && page <= totalPages && page !== currentPage) {
                                                currentPage = page;
                                                fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection);
                                            }
                                        });
                                    });
                                })
                                .catch(err => showToast('Error al cargar empresas', 'danger'));
                        }

                        // Inicial
                        fetchEmpresas();

                        // Buscar
                        searchInput.addEventListener('keyup', function() {
                            currentSearch = this.value;
                            currentPage = 1;
                            fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection);
                        });

                        // Ordenamiento
                        tableHeaders.forEach(th => {
                            th.addEventListener('click', function() {
                                const col = this.dataset.column;
                                if (!col) return;
                                if (sortColumn === col) sortDirection = (sortDirection === 'asc') ? 'desc' : 'asc';
                                else {
                                    sortColumn = col;
                                    sortDirection = 'asc';
                                }
                                fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection);
                            });
                        });

                        // --- Registro de empresa
                        const form = document.getElementById('formRegistrarEmpresa');
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);

                            fetch("{{ route('empresa.store') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    showToast(data.message, data.status === 'success' ? 'success' : 'danger');
                                    if (data.status === 'success') {
                                        form.reset();
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistrarEmpresa'));
                                        modal.hide();
                                        fetchEmpresas(1, currentSearch, sortColumn, sortDirection);
                                    }
                                })
                                .catch(err => showToast('Error al registrar empresa', 'danger'));
                        });

                        // --- Editar empresa
                        // Abrir modal de edición
                        // --- Editar empresa
                        tableBody.addEventListener('click', function(e) {
                            if (e.target.classList.contains('btn-editar')) {
                                const id = e.target.dataset.id;

                                // Llamada al servidor para traer datos de la empresa
                                fetch(`/empresa/${id}/edit`)
                                    .then(res => res.json())
                                    .then(data => {
                                        // Llenar campos del modal
                                        document.getElementById('editar-id').value = data.id;
                                        document.getElementById('editar-nombre').value = data.nombre;
                                        document.getElementById('editar-telefono').value = data.telefono ?? '';
                                        document.getElementById('editar-correo').value = data.correo ?? '';
                                        document.getElementById('editar-direccion').value = data.direccion ?? '';
                                        document.getElementById('editar-nit').value = data.nit ?? '';

                                        // Previsualizar logo
                                        const previewDiv = document.getElementById('editPreviewLogo');
                                        const previewImg = document.getElementById('editLogoPreviewImg');

                                        if (data.logo) {
                                            previewDiv.style.display = 'block';
                                            previewImg.src = `/storage/${data.logo}`;
                                        } else {
                                            previewDiv.style.display = 'none';
                                            previewImg.src = '';
                                        }

                                        // Abrir modal
                                        const modal = new bootstrap.Modal(document.getElementById('modalEditarEmpresa'));
                                        modal.show();
                                    });
                            }
                        });

                        // Cambiar logo en edición
                        document.getElementById('editar-logo').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const previewDiv = document.getElementById('editPreviewLogo');
                            const previewImg = document.getElementById('editLogoPreviewImg');
                            if (file) {
                                previewDiv.style.display = 'block';
                                previewImg.src = URL.createObjectURL(file);
                            }
                        });

                        // Quitar logo en edición
                        document.getElementById('btnQuitarLogoEdit').addEventListener('click', function() {
                            document.getElementById('editar-logo').value = '';
                            const previewDiv = document.getElementById('editPreviewLogo');
                            const previewImg = document.getElementById('editLogoPreviewImg');
                            previewDiv.style.display = 'none';
                            previewImg.src = '';
                        });

                        // Ver logo en grande con SweetAlert2 (con zIndex alto para sobre el modal)
                        document.getElementById('editLogoPreviewImg').addEventListener('click', function() {
                            if (this.src) {
                                Swal.fire({
                                    imageUrl: this.src,
                                    imageAlt: 'Logo',
                                    showConfirmButton: false,
                                    background: '#fff',
                                    width: 'auto',
                                    heightAuto: true,
                                    customClass: {
                                        popup: 'swal-wide'
                                    },
                                    // Asegura que esté sobre el modal
                                    didOpen: () => {
                                        document.querySelector('.swal-wide').style.zIndex = 20000;
                                    }
                                });
                            }
                        });

                        // --- Submit de edición
                        const formEditar = document.getElementById('formEditarEmpresa');
                        formEditar.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(formEditar);
                            const id = formData.get('id');
                            formData.append('_method', 'PUT');

                            fetch(`/empresa/${id}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    showToast(data.message, data.status === 'success' ? 'success' : 'danger');
                                    if (data.status === 'success') {
                                        formEditar.reset();
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarEmpresa'));
                                        modal.hide();
                                        fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection); // recarga tabla
                                    }
                                })
                                .catch(err => showToast('Error al actualizar empresa', 'danger'));
                        });

                    });
                </script>
            </div>
        </div>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>