var $tsp = (function ($) {
  var me = {};

  function _init() {
    console.info('_init');
    $('#tspUpdateSubscriptions').click(me.updateSubscriptions);
  }

  me.updateSubscriptions = function() {
    console.info('updateSubscriptions');
    var s2Cats = [];
    $('.tspS2Subscriptions :checked').each(function() {
      s2Cats.push($(this).val());
    });

    var data = {
      'action': 'update_subscriptions',
      's2Cats': s2Cats.join()
    };
    $.post('/wp-admin/admin-ajax.php', data, function(response) {
      console.info('received '+response+' from updating subscriptions');
      $('.tspS2Subscriptions').after('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>All saved!</strong></div>');
    })
     .fail(function() {
      $('.tspS2Subscriptions').after('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Cannot save at this time, please try later</strong></div>');
     });
  };
  
  _init();

  return me;
}(jQuery));
