var el = wp.element.createElement;

wp.blocks.registerBlockType('imbachat-widget/public-chat-block', {

    title: 'Public Chat', // Block name visible to user

    icon: 'lightbulb', // Toolbar icon can be either using WP Dashicons or custom SVG

    category: 'imbachat-chats', // Under which category the block would appear

    attributes: { // The data this block will be storing

        width: { type: 'number' , default: 800 }, // Notice box type for loading the appropriate CSS class. Default class is 'default'

        height: { type: 'number', default: 800 }, // Notice box type for loading the appropriate CSS class. Default class is 'default'.

        chatName: { type: 'string' }, // Notice box title in h4 tag

        chatSlug: { type: 'string' }, // Notice box title in h4 tag
        // content: { type: 'array', source: 'children', selector: 'p' } /// Notice box content in p tag

    },

    edit: function(props) {
        // How our block renders in the editor in edit mode

        function updateWidth( event ) {
            props.setAttributes( { width: event.target.value } );
        }

        function updateHeight( event ) {
            props.setAttributes( { height: event.target.value } );
        }

        function updateChatName( event ) {
            props.setAttributes( { chatName: event.target.value } );
        }

        function updateChatSlug (event ) {
            let value = event.target.value.replace(/ /, '_');
            props.setAttributes( { chatSlug: value } );
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
            el(
                'div',
                {},
                el(
                    'label',
                    {
                        className: 'imba_label'
                    },
                    'Chat name'
                ),
                el(
                    'input',
                    {
                        type: 'text',
                        value: props.attributes.chatName,
                        onChange: updateChatName,
                        placeholder: 'Set the name of chat',
                        style: { width: '50%' }
                    },
                ),
            ),
            el(
                'div',
                {},
                el(
                    'label',
                    {
                        className: 'imba_label'
                    },
                    'Chat slug (unique!)'
                ),
                el(
                    'input',
                    {
                        type: 'text',
                        value: props.attributes.chatSlug,
                        onChange: updateChatSlug,
                        placeholder: 'Set the slug of chat',
                        style: { width: '50%' }
                    },
                ),
            )
            // el(
            //     wp.editor.RichText,
            //     {
            //         tagName: 'p',
            //         onChange: updateContent,
            //         value: props.attributes.content,
            //         placeholder: 'Enter description here...'
            //     }
            // )
        ); // End return

    },  // End edit()

    /* block.js */
    save: function(props) {
        // How our block renders on the frontend

        return el( 'div',
            {
                id: props.attributes.chatSlug,
                className: 'imbchat-pub-box',
                style: 'width: '+props.attributes.width+'px;height:'+props.attributes.height+'px;',
                "data-imbachat_chat_ph": 1
            },
            el(
                'h4',
                null,
                props.attributes.chatName
            ),
            el(
                'script',
                null,
                "" +
                "document.addEventListener('DOMContentLoaded', () => {\n" +
                "window.imbaApi.on('imbaChat.loaded', (data) => {\n" +
                    "imbaApi.placeHolder('"+props.attributes.chatSlug+"', '"+props.attributes.chatName+"')\n" +
                "})\n" +
                "})\n"
            )

        ); // End return

    } // End save()
});