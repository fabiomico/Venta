<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Gestión de Usuarios</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            Crear Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" id="search" class="form-control" placeholder="Buscar usuario...">
                            </div>
                            <div class="col-md-4">
                                <select id="filterRole" class="form-select">
                                    <option value="">-- Filtrar por rol --</option>
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped" id="tablaUsuarios">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Crear Usuario -->
        <div class="modal fade" id="modalCrear" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Usuario</h5>
                    </div>
                    <div class="modal-body">
                        <form id="formCrear">
                            @csrf
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Rol</label>
                                <select name="role" class="form-select">
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Usuario -->
        <div class="modal fade" id="modalEditar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario</h5>
                    </div>
                    <div class="modal-body">
                        <form id="formEditar">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit_id">
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" id="edit_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Rol</label>
                                <select name="role" id="edit_role" class="form-select">
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.querySelector('#tablaUsuarios tbody');
            const search = document.getElementById('search');
            const filterRole = document.getElementById('filterRole');

            function cargarUsuarios() {
                let url = "{{ route('usuarios.lista') }}?search=" + search.value + "&role=" + filterRole.value;
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        tbody.innerHTML = '';
                        data.forEach(user => {
                            let roles = user.roles.map(r => r.name).join(', ');
                            let tr = `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${roles}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editarUsuario(${user.id}, '${user.name}', '${user.email}', '${roles}')">Editar</button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${user.id})">Eliminar</button>
                                    </td>
                                </tr>`;
                            tbody.insertAdjacentHTML('beforeend', tr);
                        });
                    });
            }

            search.addEventListener('input', cargarUsuarios);
            filterRole.addEventListener('change', cargarUsuarios);
            cargarUsuarios();

            window.editarUsuario = function(id, name, email, role) {
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_role').value = role;
                new bootstrap.Modal(document.getElementById('modalEditar')).show();
            };

            window.eliminarUsuario = function(id) {
                if (confirm('¿Seguro que quieres eliminar este usuario?')) {
                    alert('Aquí iría la petición DELETE con fetch.');
                }
            };
        });
    </script>
</x-layout>