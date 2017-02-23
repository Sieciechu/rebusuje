(function($){  
    
    $('#check_rebus').click(function(){
        
        var rebus = $('#rebus');
        var correctAnswer = decodeThePassword(rebus.data('answer')).toLowerCase();
        rebus.val(rebus.val().trim().toLowerCase());
        setInputCssAnswerClass(rebus, rebus.val() == correctAnswer);
            
    });
    
    /**
     * 
     * @param {string} $string
     * @returns {string}
     */
    function decodeThePassword($string){
        return decodeURI(window.atob($string));
    }
    
    /**
     * 
     * @param {jQuery} $input
     * @param {bool} $isCorrect
     * @returns {void}
     */
    function setInputCssAnswerClass($input, $isCorrect){
        var classToToggle = ($isCorrect) ? 'correctAnswer' : 'badAnswer';
        
        var toggleCssClassWithFadeEffect = function(){
            $input.toggleClass(classToToggle).fadeIn(500);
        };
        
        toggleCssClassWithFadeEffect();

        setTimeout(toggleCssClassWithFadeEffect, 2000);
    }
})(jQuery);