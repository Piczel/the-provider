$('.input [type=submit]').on('click', function() {

    Ajax.json($('.input [name=path]').val(), JSON.parse($('.input [name=data]').val()))
        .then(function(response) {
            $('.output [name=data]').text(response);
        });
});