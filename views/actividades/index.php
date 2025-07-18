<div class="container py-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body bg-gradient" style="background: linear-gradient(90deg, #f8fafc 60%, #e3f2fd 100%);">
                    <div class="mb-4 text-center">
                        <h5 class="fw-bold text-secondary mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de actividades de Carlos!</h5>
                        <h3 class="fw-bold text-primary mb-0">REGISTRO DE ACTIVIDADES</h3>
                    </div>
                    <form id="FormActividades" class="p-4 bg-white rounded-3 shadow-sm border">
                        <input type="hidden" id="actividad_id" name="actividad_id">
                        <div class="row g-4 mb-3">
                            <div class="col-md-6">
                                <label for="actividad_nombre" class="form-label">Nombre de la Actividad</label>
                                <input type="text" class="form-control form-control-lg" id="actividad_nombre" name="actividad_nombre" placeholder="Ingrese el nombre de la actividad" required>
                            </div> 
    
                        
                            <div class="col-md-6">
                                <label for="actividad_hora_esperada" class="form-label">Fecha y Hora programada</label>
                                <input type="datetime-local" class="form-control form-control-lg" id="actividad_hora_esperada" name="actividad_hora_esperada" required>
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
                    <h3 class="text-center text-primary mb-4">Actividades registradas</h3>

                                    <!-- FILTRO DE FECHAS -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                        <input type="date" id="fecha_fin" class="form-control form-control-lg">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary btn-lg w-100 shadow" id="btn_filtrar_fecha">
                            <i class="bi bi-funnel-fill me-2"></i>Buscar por fecha
                        </button>
                    </div>
                </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden" id="TableActividades">
                            <!-- Aquí se cargan las actividades -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Icons CDN (opcional, para los íconos de los botones) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="<?= asset('build/js/actividades/index.js') ?>"></script>
