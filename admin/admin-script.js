$(document).ready(function(){
    //console.log("jQuery strādā!")
    let edit = false;
    fetchPieteikumi()
    fetchKursi()
    fetchLietotaji()

    function fetchPieteikumi(){
        $.ajax({
            url: 'crud/pieteikumi-list.php',
            type: 'GET',
            success: function(response){
                const pieteikumi = JSON.parse(response)
                let template = ''
                pieteikumi.forEach(pieteikums =>{
                    template += `
                        <tr kursaID ="${pieteikums.id}">
                            <td>${pieteikums.id}</td>
                            <td>${pieteikums.vards}</td>
                            <td>${pieteikums.uzvards}</td>
                            <td>${pieteikums.epasts}</td>
                            <td>${pieteikums.talrunis}</td>
                            <td>${pieteikums.kurss}</td>
                            <td>${pieteikums.statuss}</td>
                            <td>
                                <a href="#" class="pieteikums-item btn-edit"><i class="fa fa-edit"></i></a> 
                                <a href="#" class="pieteikums-delete btn-delete"><i class="fa fa-trash"></i></a> 
                            </td>
                        </tr>
                    `
                })

                $('#pieteikumi').html(template)
            }
        })
    }

    $(document).on('click', '.pieteikums-item', (e) => {
        $(".modal").css('display','flex')
        const element = $(this)[0].activeElement.parentElement.parentElement
        //console.log(element)
        const id = $(element).attr('kursaID')
        $.post('crud/pieteikums-single.php', {id}, (response) =>{
            const pieteikums = JSON.parse(response)
            $('#vards').val(pieteikums.vards)
            $('#uzvards').val(pieteikums.uzvards)
            $('#epasts').val(pieteikums.epasts)
            $('#talrunis').val(pieteikums.talrunis)
            $('#komentars').val(pieteikums.komentars)
            $('#kurss').val(pieteikums.kurss)
            $('#statuss').val(pieteikums.statuss)
            $('#kursaID').val(pieteikums.id)
            edit = true
        })
        e.preventDefault()
    })

    $('#pieteikumaForma').submit(e =>{
        e.preventDefault()
        const postData = {
            vards: $('#vards').val(),
            uzvards: $('#uzvards').val(),
            epasts: $('#epasts').val(),
            talrunis: $('#talrunis').val(),
            komentars: $('#komentars').val(),
            kurss: $('#kurss').val(),
            statuss: $('#statuss').val(),
            id: $('#kursaID').val()
        }
        const url = edit === false ? 'crud/pieteikums-add.php' : 'crud/pieteikums-edit.php'
        console.log(postData, url)
        $.post(url, postData, (response) =>{
            $("#pieteikumaForma").trigger('reset')
            console.log(response)
            fetchPieteikumi()
            $(".modal").hide()
            edit = false
        })
    })

    $(document).on('click', '#new', (e) => {
        $(".modal").css('display','flex')
    })

    $(document).on('click', '.close_modal', (e) => {
        $(".modal").hide()
        edit = false
        $("#pieteikumaForma").trigger('reset')
    })



    $(document).on('click', '.pieteikums-delete', (e) => {
        if(confirm('Vai tiešām vēlies dzēst šo ierakstu?')){
            const element = $(this)[0].activeElement.parentElement.parentElement
            //console.log(element)
            const id = $(element).attr('kursaID')
            $.post('crud/pieteikums-delete.php', {id}, (response) =>{
                fetchPieteikumi()
            })
        }
    })



    //KURSI//

    function fetchKursi(){
        $.ajax({
            url: 'crud-kursi/kursi-list.php',
            type: 'GET',
            success: function(response){
                const kursi = JSON.parse(response)
                let template = ''
                kursi.forEach(kursi =>{
                    template += `
                        <tr kursiID ="${kursi.id}">
                            <td>${kursi.id}</td>
                            <td>${kursi.nosaukums}</td>
                            <td>${kursi.apraksts}</td>
                            <td><img src="${kursi.attels}" style="width: 100px; height: auto;"></td>
                            <td>
                                <a href="#" class="kursi-item btn-edit"><i class="fa fa-edit"></i></a> 
                            </td>
                        </tr>
                    `
                })

                $('#kursi').html(template)
            }
        })
    }

    $(document).on('click', '.kursi-item', (e) => {
        $(".modal").css('display','flex');
        const element = $(e.target).closest('tr');
        const id = $(element).attr('kursiID');
        $.post('crud-kursi/kursi-single.php', {id}, (response) =>{
            const kursi = JSON.parse(response);
            $('#nosaukums').val(kursi.nosaukums);
            $('#apraksts').val(kursi.apraksts);
            $('#attels').val(kursi.attels);
            $('#kursiID').val(kursi.id);
            edit = true;
        });
        e.preventDefault();
    });
    
    $('#kursaForma').submit(e => {
        e.preventDefault();
        const postData = {
            nosaukums: $('#nosaukums').val(),
            apraksts: $('#apraksts').val(),
            attels: $('#attels').val(),
            statuss: $('#statuss').val(), // Capture the status value
            kursiID: $('#kursiID').val() 
        };
        const url = edit === false ? 'crud-kursi/kursi-add.php' : 'crud-kursi/kursi-edit.php';
        console.log(postData, url);
        $.post(url, postData, (response) => {
            $("#kursaForma").trigger('reset');
            console.log(response);
            fetchKursi();
            $(".modal").hide();
            edit = false;
        });
    });

    $(document).on('click', '#new', (e) => {
        $(".modal").css('display','flex')
    })

    $(document).on('click', '.close_modal', (e) => {
        $(".modal").hide()
        edit = false
        $("#kursaForma").trigger('reset')
    })


//LIETOTAJI

    // Function to fetch lietotaji data
function fetchLietotaji() {
    $.ajax({
        url: 'crud-lietotaji/lietotaji-list.php',
        type: 'GET',
        success: function(response) {
            const lietotaji = JSON.parse(response);
            let template = '';

            lietotaji.forEach(lietotajs => {
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
            });

            $('#lietotaji').html(template);
        }
    });
}

$(document).on('click', '.lietotaji-delete', (e) => {
    if (confirm('Vai tiešām vēlies dzēst šo ierakstu?')) {
        const element = $(e.target).closest('tr');
        $(element).remove(); // Remove the row from the website only

        const id = $(element).attr('lietotajiID');


        // Example: Soft delete (change status to "dzēsts")
        $.post('crud-lietotaji/lietotaji-delete.php', { id }, (response) => {
            // Handle the response if needed
        });
    }
});

// Fetch lietotaji when the page loads
fetchLietotaji();

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

        // Update the password label and visibility based on the checkbox
        if (lietotajs.lietotajvards) {
            $('#paroleLabel').text('Change Password');
            $('#parole').prop('type', 'password');
            $('#changePassword').prop('checked', false);
        } else {
            $('#paroleLabel').text('Parole');
            $('#parole').prop('type', 'password');
            $('#changePassword').prop('checked', false);
        }
    });

    e.preventDefault();
});


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
                changePassword: $('#changePassword').prop('checked') ? 1 : 0,
            };
            const url = edit === false ? 'crud-lietotaji/lietotaji-add.php' : 'crud-lietotaji/lietotaji-edit.php';
            console.log(postData, url);
            $.post(url, postData, (response) => {
            $("#lietotajaForma").trigger('reset');
            console.log(response);
            fetchLietotaji();
            $(".modal").hide();
        edit = false;
    });
});
        
    
        $(document).on('click', '#new', (e) => {
            $(".modal").css('display','flex')
        })
    
        $(document).on('click', '.close_modal', (e) => {
            $(".modal").hide()
            edit = false
            $("#lietotajaForma").trigger('reset')
        })
})


