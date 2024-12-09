$(document).ready(function() {

    $.ajax({
        url: 'PHP/vista.php',
        dataType: 'json',
        success: function(data) {
            renderTable(data);
        },
        error: function() {
            console.error("Error al obtener los datos.");
        }
    });

    function renderTable(data) {
        let tableBody = '';
        data.forEach(user => {
            tableBody += `
                <tr>
                    <td>${user.usuario_id}</td>
                    <td>${user.nombre_completo}</td>
                    <td>${user.flor_favorita}</td>
                </tr>
            `;
        });
        $('#tbody').html(tableBody);
    }

}); 

