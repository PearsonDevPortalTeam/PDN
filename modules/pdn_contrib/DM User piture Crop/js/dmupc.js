jQuery(document).ready(function() {
  if(jQuery('input[name=dmupc_animated]').length == 0) {
    jQuery('#cropbox').Jcrop({
      aspectRatio: Drupal.settings.dmupc.a_width / Drupal.settings.dmupc.a_height,
      bgColor: 'transparent',
      onChange: dmupc_showCoords,
      onSelect: dmupc_showCoords,
        setSelect: [ 0, 0, Drupal.settings.dmupc.x,Drupal.settings.dmupc.y ]
    });
  }
});
function dmupc_showCoords(c){
  jQuery('input[name=dmupc_x1]').val(c.x);
  jQuery('input[name=dmupc_y1]').val(c.y);
  jQuery('input[name=dmupc_x2]').val(c.x2);
  jQuery('input[name=dmupc_y2]').val(c.y2);
  jQuery('input[name=dmupc_w]').val(c.w);
  jQuery('input[name=dmupc_h]').val(c.h);
}
