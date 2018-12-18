

let ajax_url = null;
let current_request = null;

function send() {
    console.log(ajax_url);
    if(ajax_url == null) return;
    
    Ajax.json(ajax_url, current_request)
    .then(function(responseText) {
        $('.form.response').empty();
        $('.form.response').append(getOutputs(JSON.parse(responseText)));
    });
}

$('.submit').on('click', send);

$('select[name=json-template]').on('change', function() {
    ajax_url = $(this).find(':selected').attr('action');
    current_request = JSON.parse(this.value);

    $('.form.request').empty();
    $('.form.request').append(getInputs(current_request));
});

function getOutputs(o) {
    let $list = $('<ul></ul>');

    for(let attribute in o) {
        $list.append(
            $('<li></li>')
            .append(
                $('<div></div>', {
                    'class' : 'attribute-label'
                }).text(attribute)
            )
        );
        //console.log(attribute +':');
        if(typeof o[attribute] === 'object') {
            $list.append(
                $('<li></li>')
                .append(
                    getOutputs(o[attribute])
                )
            );
            //console.log('Object: ', o[attribute]);   
        } else {
            $list.append(
                $('<li></li>')
                .append(
                    $('<input>')
                    .val(o[attribute])
                    .on('input', function() {
                        o[attribute] = $(this).val();
                    })
                )
            );
            //console.log('Property: '+ o[attribute]);
        }
    }

    return $list;
}

function getInputs(o) {
    let $list = $('<ul></ul>');

    for(let attr in o) {

        let attribute = attr.indexOf(' [') == -1 ? attr : attr.substring(0, attr.indexOf(' ['));
        let suffix = attr.indexOf(' [') == -1 ? '' : attr.substring(attr.indexOf(' ['), attr.length);

        $list.append(
            $('<li></li>')
            .append(
                $('<span></span>', {
                    'class' : 'attribute-label'
                }).text(attribute),
                $('<span></span>', {
                    'class' : 'suffix'
                })
                .text(suffix)
            )
        );
        //console.log(attribute +':');
        if(typeof o[attribute] === 'object') {
            $list.append(
                $('<li></li>')
                .append(
                    getInputs(o[attribute])
                )
            );
            //console.log('Object: ', o[attribute]);   
        } else {
            $list.append(
                $('<li></li>')
                .append(
                    $('<input>')
                    .on('input', function() {
                        if($(this).val().length > 0) {

                            o[attribute] = $(this).val();
                        } else {

                            delete o[attribute];
                        }
                    })
                    .val(getValue(attribute, o))
                    .trigger('input')
                )
            );
            //console.log('Property: '+ o[attribute]);
        }
    }

    return $list;
}

function getValue(attribute, o) {
    let $input = [];
    try {
        $input = $('.form.temp input[name='+ attribute +']');
    } catch(err) {
        return o[attribute]; 
    }
          
    if($input.length > 0) {
        if($input.attr('name') == attribute) {
            if($input.val().length > 0) {

                return $input.val();
            }

            return o[attribute];
        }

        return o[attribute];
    }

    return o[attribute];
    
}