<div class="container py-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body bg-gradient" style="background: linear-gradient(90deg, #f8fafc 60%, #e3f2fd 100%);">
                    <div class="mb-4 text-center">
                        <h5 class="fw-bold text-secondary mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de Asistencias!</h5>
                        <h3 class="fw-bold text-primary mb-0">REGISTRO DE ASISTENCIAS</h3>
                    </div>
                    <form id="FormAsistencias" class="p-4 bg-white rounded-3 shadow-sm border">
                        <input type="hidden" id="asistencia_id" name="asistencia_id">
                        <div class="row g-4 mb-3">
                            <div class="col-md-6">
                                <label for="actividad_id" class="form-label">Actividades</label>
                                    <select name="actividad_id" id="actividad_id" class="form-select" required>
                                        <option value="">-- Seleccione una Actividad --</option>
                                        <?php foreach($actividades as $actividad): ?>
                                            <option value="<?= $actividad->actividad_id ?>"><?= $actividad->actividad_nombre ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="col-md-6">
                                <label for="actividad_hora_esperada" class="form-label">Fecha y Hora programada</label>
                                <input type="datetime-local" class="form-control form-control-lg" id="actividad_hora_esperada" name="actividad_hora_esperada" required>
                            </div>
                            </div>
                        </div>
                        <div class="row g-4 mb-3">
                            <div class="col-md-6">
                                <label for="asistencia_fecha" class="form-label">Fecha de llegada</label>
                                <input type="date" class="form-control form-control-lg" id="asistencia_fecha" name="asistencia_fecha" placeholder="Ingrese su fecha de llegada" required>
                            </div>
                            <div class="col-md-6">
                                <label for="asistencia_hora_real" class="form-label">Hora de llegada</label>
                                <input type="" class="form-control form-control-lg" id="asistencia_hora_real" name="asistencia_hora_real" placeholder="Ingrese su número de teléfono" required>
                            </div>
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="usuario_correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="usuario_correo" name="usuario_correo" placeholder="ejemplo@ejemplo.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_estado" class="form-label">Estado del usuario</label>
                                <select name="usuario_estado" class="form-select form-select-lg" id="usuario_estado" required>
                                    <option value="">-- Seleccione el estado --</option>
                                    <option value="P">Presente</option>
                                    <option value="F">Faltando</option>
                                    <option value="C">Comisión</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_fecha" class="form-label">Ingrese la Fecha</label>
                                <input type="datetime-local" class="form-control form-control-lg" id="usuario_fecha" name="usuario_fecha" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-success btn-lg px-4 shadow" type="submit" id="BtnGuardar">
                                <i class="bi bi-save me-2"></i>Guardar
                            </button>
                            <button class="btn btn-warning btn-lg px-4 shadow d-none" type="button" id="BtnModificar">
                                <i class="bi bi-pencil-square me-2"></i>Modificar
                            </button>
                            <button class="btn btn-secondary btn-lg px-4 shadow" type="reset" id="BtnLimpiar">
                                <i class="bi bi-eraser me-2"></i>Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-11">
            <div class="card shadow-lg border-primary rounded-4">
                <div class="card-body">
                    <h3 class="text-center text-primary mb-4">Usuarios registrados en la base de datos</h3>

                                    <!-- FILTRO DE FECHAS -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                        <input type="date" id="fecha_inicio" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Fecha de fin</label>
                        <input type="date" id="fecha_fin" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary btn-lg w-100 shadow" id="btn_filtrar_fecha">
                            <i class="bi bi-funnel-fill me-2"></i>Buscar por fecha
                        </button>
                    </div>
                </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden" id="TableUsuarios">
                            <!-- Aquí se cargan los usuarios -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Icons CDN (opcional, para los íconos de los botones) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="<?= asset('build/js/asistencias/index.js') ?>"></script>
