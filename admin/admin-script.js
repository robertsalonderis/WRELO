$(document).ready(function(){
    let edit = false;

    fetchLietotaji();

    function fetchLietotaji() {
        $.ajax({
            url: 'crud-lietotaji/lietotaji-list.php',
            type: 'GET',
            success: function(response) {
                const lietotaji = JSON.parse(response);
                let template = '';

                lietotaji.forEach(lietotajs => {
                    if (lietotajs.statuss !== 'dzēsts') {
                        template += `
                            <tr lietotajiID="${lietotajs.id}">
                                <td>${lietotajs.id}</td>
                                <td>${lietotajs.lietotajvards}</td>
                                <td>${lietotajs.vards}</td>
                                <td>${lietotajs.uzvards}</td>
                                <td>${lietotajs.epasts}</td>
                                <td>${lietotajs.loma}</td>
                                <td>${lietotajs.registrets}</td>
                                <td>
                                    <a href="#" class="lietotaji-item btn-edit"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="lietotaji-delete btn-delete"><i class="fa fa-trash"></i></a> 
                                </td>
                            </tr>
                        `;
                    }
                });

                $('#lietotaji').html(template);
            }
        });
    }

    $('#lietotajaForma').submit(e => {
        e.preventDefault();
        const postData = {
            lietotajvards: $('#lietotajvards').val(),
            vards: $('#vards').val(),
            uzvards: $('#uzvards').val(),
            epasts: $('#epasts').val(),
            parole: $('#parole').val(),
            loma: $('#loma').val(),
            lietotajiID: $('#lietotajiID').val(),
        };
        const url = edit === false ? 'crud-lietotaji/lietotaji-add.php' : 'crud-lietotaji/lietotaji-edit.php';
        $.post(url, postData, (response) => {
            $("#lietotajaForma").trigger('reset');
            fetchLietotaji();
            $(".modal").hide();
            edit = false;
        });
    });

    $(document).on('click', '.lietotaji-item', (e) => {
        $(".modal").css('display', 'flex');
        const element = $(e.target).closest('tr');
        const id = $(element).attr('lietotajiID');

        $.post('crud-lietotaji/lietotaji-single.php', { id }, (response) => {
            const lietotajs = JSON.parse(response);
            $('#lietotajvards').val(lietotajs.lietotajvards);
            $('#vards').val(lietotajs.vards);
            $('#uzvards').val(lietotajs.uzvards);
            $('#epasts').val(lietotajs.epasts);
            $('#loma').val(lietotajs.loma);
            $('#lietotajiID').val(lietotajs.id);
            edit = true;

            $('#parole').val('');
        });

        e.preventDefault();
    });

    $(document).on('click', '.lietotaji-delete', (e) => {
        if (confirm('Vai tiešām vēlies dzēst šo ierakstu?')) {
            const element = $(e.target).closest('tr');
            const id = $(element).attr('lietotajiID');

            $.post('crud-lietotaji/lietotaji-delete.php', { id }, (response) => {
                fetchLietotaji();
            });
        }
    });

    $(document).on('click', '#new', (e) => {
        $(".modal").css('display','flex');
    });

    $(document).on('click', '.close_modal', (e) => {
        $(".modal").hide();
        edit = false;
        $("#lietotajaForma").trigger('reset');
    });
});






