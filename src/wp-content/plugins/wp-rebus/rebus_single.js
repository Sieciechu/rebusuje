
(function(){
    jQuery('#check_rebus').click(function(){
        
        var rebus = document.getElementById('rebus');
        var correctAnswer = window.atob(
            rebus.dataset.answer
        );
        correctAnswer = correctAnswer.toLowerCase();
        rebus.value = rebus.value.trim().toLowerCase();
        
        alert('Twoja odpowiedź jest ' + ((rebus.value != correctAnswer) ? 'nieprawidłowa' : 'prawidłowa'));
            
    });
})();