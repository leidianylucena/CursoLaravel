// Receber o seletor do campo valor
let inputValor = document.getElementById('valor');

// Aguardar o usuário digitar valor no campo
inputValor.addEventListener('input', function(){

    // Obter o valor atual removendo qualquer caractere que não seja número
    let valueValor = this.value.replace(/[^\d]/g, '');

    // Adicionar os separadores de milhares
    var formattedValor = (valueValor.slice(0, -2).replace(/\B(?=(\d{3})+(?!\d))/g, '.')) + '' + valueValor.slice(-2);

    // Adicionar a vírgula e até dois dígitos se houver centavos
    formattedValor = formattedValor.slice(0, -2) + ',' + formattedValor.slice(-2);

    // Atualizar o valor do campo
    this.value = formattedValor;

});

function confirmarExclusao(event, contaId){

    event.preventDefault();

    Swal.fire({
        title: 'Tem certeza?',
        text: 'Você não poderá reverter isso!',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#0d6efd',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Sim, excluir!',
    }).then((result) => {
        if(result.isConfirmed){
            document.getElementById(`formExcluir${contaId}`).submit();
        }
    })

}
