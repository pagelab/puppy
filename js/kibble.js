jQuery(document).ready(function($) {

    var kibble_sti_media_file_frame;

    $('#kibble_tax_add_image').on('click', function(e) {
        e.preventDefault();
        if (kibble_sti_media_file_frame) {
            kibble_sti_media_file_frame.open();
            return;
        }

        kibble_sti_media_file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select An Image',
            button: {
                text: 'Use Image'
            },
            class: $(this).attr('id')
        });

        kibble_sti_media_file_frame.on('select', function() {
            var attachment = kibble_sti_media_file_frame.state().get('selection').first().toJSON();
            $('#kibble_tax_image_preview').attr('src', attachment.url).css('display', 'block');
            $('#kibble_tax_image').attr('value', attachment.id);
            $('#kibble_tax_remove_image').css('display', 'inline-block');
        });
        kibble_sti_media_file_frame.open();
    });

    $('#kibble_tax_remove_image').on('click', function(e) {
        e.preventDefault();
        $(this).css('display', 'none');
        $('#kibble_tax_image_preview').css('display', 'none');
        $('#kibble_tax_image').attr('value', '');
    });

}); 
