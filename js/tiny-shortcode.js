(function() {
    tinymce.PluginManager.add('pcs_tc_button', function( editor, url ) {
        editor.addButton( 'pcs_tc_button', {
            text: 'Post Shortcode',
            icon: "pcsicon",
            onclick: function(e) {
               e.stopPropagation();
               editor.windowManager.open( {
                   title: 'Post Shortcode',
                   body: [
                   {
                       type: 'textbox',
                       name: 'excerptl',
                       label: 'Excerpt Length'
                   },
                   {
                       type: 'textbox',
                       name: 'rmt',
                       label: 'Read More Title'
                   },
                   {
                       type: 'textbox',
                       name: 'scf',
                       label: 'Show Custom Fields'
                   },
                   {
                       type: 'textbox',
                       name: 'postno',
                       label: 'Number Of Post'
                   },
                   {
                       type: 'listbox', 
                       name: 'template', 
                       label: 'Template', 
                       'values': [  {text: 'post', value: 'post'},
                           {text: 'page', value: 'page'},
                           {text: 'products', value: 'products'},]
                   },
                   {
                       type: 'listbox', 
                       name: 'showfield', 
                       label: 'Show Field', 
                       'values': [
                           {text: 'False', value: 'false'},
                           {text: 'True', value: 'true'},
                       ]
                   },
                   {
                       type: 'listbox', 
                       name: 'tsize', 
                       label: 'Thumbnail Size', 
                       'values': [
                           {text: 'False', value: 'false'},
                           {text: 'True', value: 'true'},
                       ]
                   },
                    {
                       type: 'listbox', 
                       name: 'orderby', 
                       label: 'Order By', 
                       'values': [
                           {text: 'False', value: 'false'},
                           {text: 'True', value: 'true'},
                       ]
                   },
                   {
                       type: 'listbox', 
                       name: 'order', 
                       label: 'Order', 
                       'values': [
                           {text: 'False', value: 'false'},
                           {text: 'True', value: 'true'},
                       ]
                   }],
                   onsubmit: function( e ) {
                       editor.insertContent( '&#91;pcs title="' + e.data.title + '" title2="' + e.data.title1 + '" style="' + e.data.level + '" class="'+ e.data.classes +'"  size="'+ e.data.sizes +'" color="'+e.data.color+'" link="'+e.data.link+'"&#93;');
                   }
               });
           }  
        });
    });
})();