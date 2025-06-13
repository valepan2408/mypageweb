<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Citas - IMSS</title>
  <link rel="stylesheet" href="harry styles.css">
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="logo-container">
        <div class="logo">
          <img src="image.png" alt="IMSS Logo">
        </div>
        <div class="header-text">
          <h1>IMSS Bienestar</h1>
          <p>Registro de Pacientes y Citas</p>
        </div>
      </div>
    </div>
  </header>

  <div class="container">

    <section class="section">
      <h2>Registro de Paciente</h2>
      <form id="pacienteForm">
        <div class="form-grid">
          <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" placeholder="Ingrese el nombre completo" required>
          </div>
          <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" id="edad" placeholder="Ingrese la edad" required min="1" max="120">
          </div>
          <div class="form-group">
            <label for="sexo">Sexo</label>
            <select id="sexo" required>
              <option value="">Seleccione el sexo</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
              <option value="38 + tipos">Otro</option>
            </select>
          </div>
          <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" id="correo" placeholder="ejemplo@correo.com" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" placeholder="Debe tener 10 digitos" required pattern="[0-9]{10}" maxlength="10">
          </div>
          <div class="form-group">
            <label for="direccion">Dirección Completa</label>
            <textarea id="direccion" placeholder="Calle, número, colonia, ciudad, estado" required></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary"> Registrar Paciente</button>
      </form>
    </section>

    <section class="section">
      <h2>Agendar Cita Médica</h2>
      <form id="citaForm">
        <div class="form-grid">
          <div class="form-group">
            <label for="pacienteSelect">Paciente</label>
            <select id="pacienteSelect" required>
              <option value="">Seleccione un paciente</option>
            </select>
          </div>
          <div class="form-group">
            <label for="fecha">Fecha de la Cita</label>
            <input type="date" id="fecha" required>
          </div>
          <div class="form-group">
            <label for="hora">Hora de la Cita</label>
            <input type="time" id="hora" required>
          </div>
          <div class="form-group">
            <label for="especialidad">Especialidad Médica</label>
            <select id="especialidad" required>
              <option value="">Seleccione especialidad</option>
              <option value="Medicina General">🏥 Medicina General</option>
              <option value="Pediatría">👶 Pediatría</option>
              <option value="Ginecología">👩‍⚕️ Ginecología</option>
              <option value="Dentista">🦷 Dentista</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-primary"> Agendar Cita</button>
      </form>
    </section>

    <section class="section">
      <h2> Citas Agendadas</h2>
      <div class="search-container">
        <div class="search-grid">
          <div class="form-group">
            <label for="filtroB">🔍 Buscar Citas</label>
            <input type="text" id="filtroB" placeholder="Buscar por nombre del paciente o especialidad...">
          </div>
          <button onclick="filtrarCitas()" class="btn btn-primary">Buscar</button>
          <button onclick="limpiarFiltro()" class="btn btn-secondary">Limpiar</button>
        </div>
      </div>
      
      <div class="table-container">
        <table id="tablaCitas">
          <thead>
            <tr>
              <th>👤 Paciente</th>
              <th>📅 Fecha</th>
              <th>🕐 Hora</th>
              <th>🏥 Especialidad</th>
              <th>⚡ Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </section>
  </div>

  <script>
    let pacientes = [];
    let citas = [];

    
    document.addEventListener('DOMContentLoaded', function() {
      cargarPacientes();
      cargarCitas();
      
      // Establecer fecha mínima como hoy
      const fechaInput = document.getElementById('fecha');
      const today = new Date().toISOString().split('T')[0];
      fechaInput.min = today;
    });

    
    document.getElementById('pacienteForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData();
      formData.append('nombre', document.getElementById('nombre').value);
      formData.append('edad', document.getElementById('edad').value);
      formData.append('sexo', document.getElementById('sexo').value);
      formData.append('correo', document.getElementById('correo').value);
      formData.append('telefono', document.getElementById('telefono').value);
      formData.append('direccion', document.getElementById('direccion').value);
      
      fetch('registrar_paciente.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          this.reset();
          cargarPacientes();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        alert('Error de conexión: ' + error);
      });
    });

    
    document.getElementById('citaForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData();
      formData.append('paciente_id', document.getElementById('pacienteSelect').value);
      formData.append('fecha', document.getElementById('fecha').value);
      formData.append('hora', document.getElementById('hora').value);
      formData.append('especialidad', document.getElementById('especialidad').value);
      
      fetch('agendar_cita.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(data.message);
          this.reset();
          cargarCitas();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        alert('Error de conexión: ' + error);
      });
    });

    function cargarPacientes() {
      fetch('obtener_pacientes.php')
      .then(response => response.json())
      .then(data => {
        pacientes = data;
        const select = document.getElementById('pacienteSelect');
        select.innerHTML = '<option value="">Selecciona paciente</option>';
        
        data.forEach(paciente => {
          const option = document.createElement('option');
          option.value = paciente.id;
          option.textContent = paciente.nombre;
          select.appendChild(option);
        });
      })
      .catch(error => {
        console.error('Error al cargar pacientes:', error);
      });
    }

    function cargarCitas(filtro = '') {
      const url = filtro ? `obtener_citas.php?filtro=${encodeURIComponent(filtro)}` : 'obtener_citas.php';
      
      fetch(url)
      .then(response => response.json())
      .then(data => {
        citas = data;
        const tbody = document.querySelector('#tablaCitas tbody');
        tbody.innerHTML = '';
        
        data.forEach(cita => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${cita.paciente}</td>
            <td>${cita.fecha}</td>
            <td>${cita.hora}</td>
            <td>${cita.especialidad}</td>
            <td>
              <button onclick="cancelarCita(${cita.id})" class="btn btn-danger">❌ Cancelar</button>
            </td>
          `;
          tbody.appendChild(row);
        });
      })
      .catch(error => {
        console.error('Error al cargar citas:', error);
      });
    }

    function cancelarCita(citaId) {
      if (confirm('¿Estás seguro de que quieres cancelar esta cita?')) {
        const formData = new FormData();
        formData.append('cita_id', citaId);
        
        fetch('cancelar_cita.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(data.message);
            cargarCitas();
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          alert('Error de conexión: ' + error);
        });
      }
    }

    function filtrarCitas() {
      const filtro = document.getElementById('filtroB').value;
      cargarCitas(filtro);
    }

    function limpiarFiltro() {
      document.getElementById('filtroB').value = '';
      cargarCitas();
    }

    
    document.getElementById('filtroB').addEventListener('input', function() {
      const filtro = this.value;
      cargarCitas(filtro);
    });
  </script>
</body>
</html>