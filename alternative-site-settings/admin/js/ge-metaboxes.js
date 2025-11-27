const { registerPlugin } = wp.plugins;
const { PluginDocumentSettingPanel } = wp.editor;
const { MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { Button, PanelBody, TextControl, TextareaControl } = wp.components;
const { useSelect, useDispatch } = wp.data;

const ImageMetaBox = () => {
    const { meta } = useSelect((select) => ({
        meta: select('core/editor').getEditedPostAttribute('meta')
    }));
    const { editPost } = useDispatch('core/editor');
    
    const updateMeta = (key, value) => {
        editPost({
            meta: {
                ...meta,
                [key]: value
            }
        });
    };

    return wp.element.createElement(
        PluginDocumentSettingPanel,
        {
            name: 'seo-meta-panel',
            title: geScriptData.i18n_panel_title,
            className: 'ge-seo-meta-panel'
        },
        wp.element.createElement('h3',
                {
                style: { 
                    margin: '0', 
                    padding: '20px 0 0 0', 
                }
            },
            geScriptData.i18n_title_label),
        wp.element.createElement(TextControl, {
            label: geScriptData.i18n_title_label,
            hideLabelFromVision: true,
            value: meta?._seo_meta_title || '',
            onChange: (value) => updateMeta('_seo_meta_title', value),
            placeholder: "",
            __next40pxDefaultSize: true,
            __nextHasNoMarginBottom: true,
        }),
        
        wp.element.createElement('h3',
                {
                style: { 
                    margin: '0', 
                    padding: '20px 0 0 0', 
                }
            },
            geScriptData.i18n_desc_label),
        wp.element.createElement(TextareaControl, {
            label: geScriptData.i18n_desc_label,
            hideLabelFromVision: true,
            value: meta?._seo_meta_description || '',
            onChange: (value) => updateMeta('_seo_meta_description', value),
            placeholder: "",
            rows: 4,
            __nextHasNoMarginBottom: true,
        }),
        wp.element.createElement('input', {
            type: 'hidden',
            value: meta?._seo_meta_og_image || '',
            onChange: (e) => updateMeta('_seo_meta_og_image', e.target.value)
        }),
        wp.element.createElement('h3',
                {
                style: { 
                    margin: '0', 
                    padding: '20px 0 0 0', 
                }
            },
            geScriptData.i18n_ogimage_label),
        wp.element.createElement(
            'div',
            {
                style: { 
                    border: '1px solid #999', 
                    borderRadius: '4px', 
                    padding: '6px', 
                }
            },
            wp.element.createElement('p', {}, geScriptData.i18n_ogimage_res_label),
            wp.element.createElement(
                MediaUploadCheck,
                {},
                wp.element.createElement(
                    MediaUpload,
                    {
                        onSelect: (media) => {
                            updateMeta('_seo_meta_og_image', media.url.replace(/^https?:\/\/[^\/]+/, ''));
                        },
                        allowedTypes: ['image'],
                        value: meta?._seo_meta_og_image?.id,
                        render: ({ open }) => {
                            const imageUrl = meta?._seo_meta_og_image;
                            
                            return wp.element.createElement(
                                'div',
                                {},
                                imageUrl && wp.element.createElement('div', {},
                                    wp.element.createElement('img', {
                                        src: imageUrl,
                                        style: { 
                                            maxWidth: '100%', 
                                            height: 'auto',
                                            marginBottom: '12px'
                                        }
                                    })
                                ),
                                wp.element.createElement(
                                    Button,
                                    {
                                        onClick: open,
                                        variant: imageUrl ? "secondary" : "primary",
                                        icon: "format-image"
                                    },
                                    imageUrl ? geScriptData.i18n_replace_image_label : geScriptData.i18n_select_image_label
                                ),
                                imageUrl && wp.element.createElement(Button, {
                                    onClick: () => updateMeta('_seo_meta_og_image', null),
                                    variant: "link",
                                    isDestructive: true,
                                    style: { marginLeft: '8px' }
                                }, geScriptData.i18n_delete_image_label)
                            );
                        }
                    }
                )
            )
        )
    );
};

registerPlugin('image-meta-box', { render: ImageMetaBox });