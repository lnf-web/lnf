(function($){
    $(".event-form").each(function(){
        var $this = $(this);
        
        var scrollY = localStorage.getItem('scrollY');
        
        if (scrollY){
            $(document).scrollTop(scrollY);
        }
        
        $this.on("click", ".submit", function(e){
            // save the scroll position
            localStorage.setItem('scrollY', $(document).scrollTop());
        });
    });
}(jQuery));