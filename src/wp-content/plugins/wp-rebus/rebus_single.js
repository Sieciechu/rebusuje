
(function(){
    jQuery('#check_rebus').click(function(){
        
        var rebus = document.getElementById('rebus');
        var correctAnswer = decodeThePassword(rebus.dataset.answer).toLowerCase();
            
        rebus.value = rebus.value.trim().toLowerCase();
        
        alert('Twoja odpowiedź jest ' + ((rebus.value != correctAnswer) ? 'nieprawidłowa' : 'prawidłowa'));
            
    });
    
    
    /**
     * 
     * @param {string} $string
     * @returns {string}
     */
    function decodeThePassword($string){
        return decodeURI(window.atob($string));
    }
    
})();