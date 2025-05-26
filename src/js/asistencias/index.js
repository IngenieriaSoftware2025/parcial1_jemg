import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import { data } from "jquery";

const FormAsistencias = document.getElementById('FormAsistencias');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const FechaInicio = document.getElementById('fecha_inicio');
const FechaFin = document.getElementById('fecha_fin');
const FiltroActividad = document.getElementById('filtro_actividad');
const BtnFiltrarFecha = document.getElementById('btn_filtrar_fecha');

const GuardarAsistencia = async (event) => {

    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormAsistencias, ['asistencia_id'])) {
        await Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe seleccionar una actividad",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return; 
    }

    const body = new FormData(FormAsistencias);

    const url = '/parcial1_jemg/asistencias/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        console.log(datos);
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Asistencia Registrada!",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarAsistencias();

        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.error(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "Ocurrió un problema al conectar con el servidor",
            showConfirmButton: true,
        });
    }
    
    BtnGuardar.disabled = false;
}

const BuscarAsistencias = async () => {

    const fecha_inicio = FechaInicio?.value || '';
    const fecha_fin = FechaFin?.value || '';
    const actividad_id = FiltroActividad?.value || '';

    const params = new URLSearchParams();

    if (fecha_inicio) params.append('fecha_inicio', fecha_inicio);
    if (fecha_fin) params.append('fecha_fin', fecha_fin);
    if (actividad_id) params.append('actividad_id', actividad_id);

    const url = `/parcial1_jemg/asistencias/buscarAPI?${params.toString()}`;
    const config = {
        method: 'GET'
    }

    try {

        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos

        if (codigo == 1) {

            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Exito",
                text: mensaje,
                showConfirmButton: true,
            });

            datatable.clear().draw();
            datatable.rows.add(data).draw();

        } else {

            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }

    } catch (error) {
        console.log(error)
    }
}

const datatable = new DataTable('#TableAsistencias', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'asistencia_id',
            width: '%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Actividad', data: 'actividad_nombre' },
        { 
            title: 'Hora Esperada', 
            data: 'actividad_hora_esperada',
            render: (data, type, row, meta) => {
                const fecha = new Date(data);
                return fecha.toLocaleString('es-ES', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        },
        { 
            title: 'Hora de Llegada', 
            data: 'asistencia_hora_llegada',
            render: (data, type, row, meta) => {
                const fecha = new Date(data);
                return fecha.toLocaleString('es-ES', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        },
        { 
            title: 'Estado', 
            data: 'estado_puntualidad',
            render: (data, type, row, meta) => {
                const badge = data === 'Puntual' 
                    ? '<span class="badge bg-success fs-6">Puntual</span>'
                    : '<span class="badge bg-danger fs-6">Tarde</span>';
                return badge;
            }
        },
        {
            title: 'Acciones',
            data: 'asistencia_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                 <div class='d-flex justify-content-center'>
                     <button class='btn btn-warning modificar mx-1' 
                         data-id="${data}" 
                         data-actividad="${row.actividad_id}"  
                         data-fecha="${row.asistencia_hora_llegada}"> 
                         <i class='bi bi-pencil-square me-1'></i> Modificar
                     </button>
                     <button class='btn btn-danger eliminar mx-1' 
                         data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                     </button>
                 </div>`;
            }
        }
    ]
});

const llenarFormulario = (event) => {

    const datos = event.currentTarget.dataset

    document.getElementById('asistencia_id').value = datos.id
    document.getElementById('actividad_id').value = datos.actividad

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0,
    })

}

const limpiarTodo = () => {

    FormAsistencias.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarAsistencia = async (event) => {

    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormAsistencias, [''])) {
        await Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe validar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return; 
    }

    const body = new FormData(FormAsistencias);

    const url = '/parcial1_jemg/asistencias/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {

        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {

            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarAsistencias();

        } else {

            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });

        }

    } catch (error) {
        console.error(error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "Hubo un problema al conectar con el servidor",
            showConfirmButton: true,
        });
    }

    BtnModificar.disabled = false;
}

const EliminarAsistencias = async (e) => {

    const idAsistencia = e.currentTarget.dataset.id

    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "info",
        title: "¿Desea ejecutar esta acción?",
        text: 'Esta completamente seguro que desea eliminar este registro',
        showConfirmButton: true,
        confirmButtonText: 'Si, Eliminar',
        confirmButtonColor: 'red',
        cancelButtonText: 'No, Cancelar',
        showCancelButton: true
    });

    if (AlertaConfirmarEliminar.isConfirmed) {

        const url =`/parcial1_jemg/asistencias/eliminar?id=${idAsistencia}`;
        const config = {
            method: 'GET'
        }

        try {

            const consulta = await fetch(url, config);
            const respuesta = await consulta.json();
            const { codigo, mensaje } = respuesta;

            if (codigo == 1) {

                await Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Exito",
                    text: mensaje,
                    showConfirmButton: true,
                });
                
                BuscarAsistencias();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }

        } catch (error) {
            console.log(error)
        }

    }

}

BuscarAsistencias();
datatable.on('click', '.eliminar', EliminarAsistencias);
datatable.on('click', '.modificar', llenarFormulario);
FormAsistencias.addEventListener('submit', GuardarAsistencia);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarAsistencia);
BtnFiltrarFecha.addEventListener('click', BuscarAsistencias);