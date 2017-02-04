jQuery(document).ready(function($) {
    $.mobile.loading().hide();
    
    var links= jQuery('.post-navigation');
    
    var img = jQuery('.post-content img');
    
    img.on('swiperight',function(){
        var link = links.find('a.post-nav-prev');
        if(link.length>0){
            window.location.href = link[0].href;
        }
    });
    
    img.on('swipeleft',function(){
        var link = links.find('a.post-nav-next');
        if(link.length>0){
            window.location.href = link[0].href;
        }
    });
    
});