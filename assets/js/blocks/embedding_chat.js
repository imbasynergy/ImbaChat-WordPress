var el = wp.element.createElement;

wp.blocks.registerBlockType('imbachat-widget/embedding-chat-block', {

    title: 'Embedding Chat', // Block name visible to user

    icon: 'lightbulb', // Toolbar icon can be either using WP Dashicons or custom SVG

    category: 'imbachat-chats', // Under which category the block would appear

    attributes: { // The data this block will be storing

        width: { type: 'number' , default: 800 }, // Notice box type for loading the appropriate CSS class. Default class is 'default'

        height: { type: 'number', default: 800 }, // Notice box type for loading the appropriate CSS class. Default class is 'default'.
    },

    edit: function(props) {
        // How our block renders in the editor in edit mode

        function updateWidth( event ) {
            props.setAttributes( { width: event.target.value } );
        }

        function updateHeight( event ) {
            props.setAttributes( { height: event.target.value } );
        }

        return el( 'div',
            {
                className: 'imbchat-pub-box'
            },
            el(
                'div',
                {

                },
                el(
                    'label',
                    {
                        className: 'imba_label'
                    },
                    'Width'
                ),
                el(
                    'input',
                    {
                        type: 'number',
                        value: props.attributes.width,
                        placeholder: 'Set the width of chat block',
                        onChange: updateWidth,
                        style: { width: '50%' }
                    },
                ),
            ),
            el('div',{},
                el(
                    'label',
                    {
                        className: 'imba_label'
                    },
                    'Height'
                ),
                el(
                    'input',
                    {
                        type: 'number',
                        value: props.attributes.height,
                        placeholder: 'Set the height of chat block',
                        onChange: updateHeight,
                        style: { width: '50%' }
                    },
                )
            ),
        ); // End return

    },  // End edit()

    /* block.js */
    save: function(props) {
        // How our block renders on the frontend

        return el( 'div',
            {
                id: 'imbachat_holder',
                className: 'imbchat-pub-box',
                style: 'width: '+props.attributes.width+'px;height:'+props.attributes.height+'px;',
                "data-imbachat_chat_ph": 1
            }
        ); // End return

    } // End save()
});