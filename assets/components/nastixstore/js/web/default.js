var nastixstore = {
    options: {
        live_form: '.ns_form',
        cart: '.nsCart',
        counter: ".nsCart input[name=count]"
    },
    initialize: function(){
        if($(this.options.live_form).length){
            $(document).on("submit", this.options.live_form, function(e){
                e.preventDefault();
                const data = $(this).serialize();
                nastixstore.send(data);
            })
            $(document).on("change", this.options.counter, function(){
                $(this).closest(nastixstore.options.live_form).trigger("submit")
            })
        }
    },
    send: function(data){
        var response = '';
        $.ajax({
            type: "POST",
            url: nastixstoreConfig['actionUrl'],
            dataType: 'json',
            data: data,
            success:  function(data_r) {
                console.log(data_r);
                if(data_r.show_success){
                    $('#successAdd').modal('show')
                }
                if(data_r.hasOwnProperty('total_count')){
                    $(nastixstore.options.cart).find(".ns_total_count").text(data_r.total_count)
                }
                if(data_r.hasOwnProperty('total_cost')){
                    $(nastixstore.options.cart).find(".ns_total_cost").text(data_r.total_cost)
                }
                if(data_r.hasOwnProperty('remove_key')){
                    $(nastixstore.options.cart).find("#key_"+data_r.remove_key).remove()
                }
                if(data_r.hasOwnProperty('redirect')){
                    document.location = data_r.redirect;
                }
            }
        });
    }
}

$(document).ready(function(){
    nastixstore.initialize();
})
