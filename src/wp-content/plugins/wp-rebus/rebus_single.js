
(function(){
    jQuery('#check_rebus').click(function(){
        
        var rebus = document.getElementById('rebus');
        var correctAnswer = window.atob(
            rebus.dataset.answer
        );
        
        alert('Twoja odpowiedź jest ' + ((rebus.value != correctAnswer) ? 'nieprawidłowa' : 'prawidłowa'));
            
    });
})();