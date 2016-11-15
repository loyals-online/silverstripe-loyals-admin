<?php

/**
 * An extension of the data extension class to add Loyals Admin settings to site config.
 */
class LoyalsConfigExtension extends DataExtension
{
    private static $db = array(
        'LoyalsLinkColor' => 'Color',
        'LoyalsLogoBkgColor' => 'Color',
        'LoyalsHighlightColor' => 'Color',
        'LoyalsProfileLinkColor' => 'Color',
        'LoyalsApplicationName' => 'Varchar(255)',
        'LoyalsApplicationLink' => 'Varchar(2048)',
        'LoyalsLogoImageWidth' => 'Varchar(16)',
        'LoyalsLogoImageHeight' => 'Varchar(16)',
        'LoyalsLogoImageResize' => 'Varchar(16)',
        'LoyalsLoadingImageWidth' => 'Varchar(16)',
        'LoyalsLoadingImageHeight' => 'Varchar(16)',
        'LoyalsLoadingImageResize' => 'Varchar(16)',
        'LoyalsSupportRetina' => 'Boolean',
        'LoyalsHideSiteName' => 'Boolean'
    );
    
    private static $has_one = array(
        'LoyalsLogoImage' => 'Image',
        'LoyalsLoadingImage' => 'Image'
    );
    
    private static $defaults = array(
        'LoyalsLinkColor' => '007FBA',
        'LoyalsLogoBkgColor' => '1B354C',
        'LoyalsHighlightColor' => '139FDA',
        'LoyalsProfileLinkColor' => '3EBAE0',
        'LoyalsSupportRetina' => 1,
        'LoyalsHideSiteName' => 0
    );
    
    /**
     * @config
     * @var string
     */
    private static $asset_path = "Uploads/Loyals";
    
    /**
     * Answers the path to use for uploading images.
     *
     * @return string
     */
    public static function get_asset_path()
    {
        return Config::inst()->get(__CLASS__, 'asset_path');
    }
    
    /**
     * Answers an array of image resize methods.
     *
     * @return array
     */
    public static function get_resize_methods()
    {
        return Config::inst()->get(__CLASS__, 'resize_methods');
    }
    
    /**
     * Updates the CMS fields of the extended object.
     *
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        // Create Loyals Tab Set:
        
        $fields->addFieldToTab(
            'Root',
            TabSet::create(
                'Loyals',
                _t('LoyalsConfigExtension.LOYALS', 'Loyals')
            )
        );
        
        // Create Colors Tab:
        
        $fields->findOrMakeTab('Root.Loyals.Colors', _t('LoyalsConfigExtension.COLORS', 'Colors'));
        
        // Create Colors Fields:
        
        $fields->addFieldsToTab(
            'Root.Loyals.Colors',
            array(
                ColorField::create(
                    'LoyalsHighlightColor',
                    _t('LoyalsConfigExtension.HIGHLIGHTCOLOR', 'Highlight color')
                ),
                ColorField::create(
                    'LoyalsLogoBkgColor',
                    _t('LoyalsConfigExtension.LOGOBACKGROUNDCOLOR', 'Logo background color')
                ),
                ColorField::create(
                    'LoyalsLinkColor',
                    _t('LoyalsConfigExtension.LINKCOLOR', 'Link color')
                ),
                ColorField::create(
                    'LoyalsProfileLinkColor',
                    _t('LoyalsConfigExtension.PROFILELINKCOLOR', 'Profile link color')
                )
            )
        );
        
        // Create Branding Tab:
        
        $fields->findOrMakeTab('Root.Loyals.Branding', _t('LoyalsConfigExtension.BRANDING', 'Branding'));
        
        // Create Branding Fields:
        
        $fields->addFieldsToTab(
            'Root.Loyals.Branding',
            array(
                TextField::create(
                    'LoyalsApplicationName',
                    _t('LoyalsConfigExtension.APPLICATIONNAME', 'Application name')
                ),
                TextField::create(
                    'LoyalsApplicationLink',
                    _t('LoyalsConfigExtension.APPLICATIONLINK', 'Application link')
                ),
                ToggleCompositeField::create(
                    'LoyalsLogoToggle',
                    _t('LoyalsConfigExtension.LOGOIMAGETOGGLETITLE', 'Logo Image'),
                    array(
                        UploadField::create(
                            'LoyalsLogoImage',
                            _t('LoyalsConfigExtension.LOGOIMAGE', 'Logo image')
                        )->setAllowedFileCategories('image')->setFolderName(self::get_asset_path()),
                        FieldGroup::create(
                            _t('LoyalsConfigExtension.DIMENSIONSINPIXELS', 'Dimensions (in pixels)'),
                            array(
                                TextField::create('LoyalsLogoImageWidth', '')->setAttribute(
                                    'placeholder',
                                    _t('LoyalsConfigExtension.WIDTH', 'Width')
                                ),
                                LiteralField::create('LoyalsLogoImageBy', '<i class="fa fa-times by"></i>'),
                                TextField::create('LoyalsLogoImageHeight', '')->setAttribute(
                                    'placeholder',
                                    _t('LoyalsConfigExtension.HEIGHT', 'Height')
                                )
                            )
                        ),
                        DropdownField::create(
                            'LoyalsLogoImageResize',
                            _t('LoyalsConfigExtension.RESIZEMETHOD', 'Resize method'),
                            self::get_resize_methods()
                        )->setEmptyString(' '),
                        CheckboxField::create(
                            'LoyalsHideSiteName',
                            _t('LoyalsConfigExtension.HIDESITENAME', 'Hide site name')
                        ),
                        CheckboxField::create(
                            'LoyalsSupportRetina',
                            _t('LoyalsConfigExtension.SUPPORTRETINADEVICES', 'Support Retina devices')
                        )
                    )
                ),
                ToggleCompositeField::create(
                    'LoyalsLoadingToggle',
                    _t('LoyalsConfigExtension.LOADINGIMAGETOGGLETITLE', 'Loading Image'),
                    array(
                        UploadField::create(
                            'LoyalsLoadingImage',
                            _t('LoyalsConfigExtension.LOADINGIMAGE', 'Loading image')
                        )->setAllowedFileCategories('image')->setFolderName(self::get_asset_path()),
                        FieldGroup::create(
                            _t('LoyalsConfigExtension.DIMENSIONSINPIXELS', 'Dimensions (in pixels)'),
                            array(
                                TextField::create('LoyalsLoadingImageWidth', '')->setAttribute(
                                    'placeholder',
                                    _t('LoyalsConfigExtension.WIDTH', 'Width')
                                ),
                                LiteralField::create('LoyalsLoadingImageBy', '<i class="fa fa-times by"></i>'),
                                TextField::create('LoyalsLoadingImageHeight', '')->setAttribute(
                                    'placeholder',
                                    _t('LoyalsConfigExtension.HEIGHT', 'Height')
                                )
                            )
                        ),
                        DropdownField::create(
                            'LoyalsLoadingImageResize',
                            _t('LoyalsConfigExtension.RESIZEMETHOD', 'Resize method'),
                            self::get_resize_methods()
                        )->setEmptyString(' ')
                    )
                )
            )
        );
    }
    
    /**
     * Event method called before the receiver is written to the database.
     */
    public function onBeforeWrite()
    {
        if ($w = $this->owner->LoyalsLogoImageWidth) {
            $this->owner->LoyalsLogoImageWidth = is_numeric($w) ? (int) $w : null;
        }
        
        if ($h = $this->owner->LoyalsLogoImageHeight) {
            $this->owner->LoyalsLogoImageHeight = is_numeric($h) ? (int) $h : null;
        }
        
        if ($w = $this->owner->LoyalsLoadingImageWidth) {
            $this->owner->LoyalsLoadingImageWidth = is_numeric($w) ? (int) $w : null;
        }
        
        if ($h = $this->owner->LoyalsLoadingImageHeight) {
            $this->owner->LoyalsLoadingImageHeight = is_numeric($h) ? (int) $h : null;
        }
    }
    
    /**
     * Answers true if a custom logo image exists.
     *
     * @return boolean
     */
    public function LoyalsLogoImageExists()
    {
        if ($image = $this->owner->LoyalsLogoImage()) {
            return ($image->exists() && file_exists($image->getFullPath()));
        }
        
        return false;
    }
    
    /**
     * Answers true if a custom loading image exists.
     *
     * @return boolean
     */
    public function LoyalsLoadingImageExists()
    {
        if ($image = $this->owner->LoyalsLoadingImage()) {
            return ($image->exists() && file_exists($image->getFullPath()));
        }
        
        return false;
    }
    
    /**
     * Answers a resized version of the logo image.
     *
     * @return Image
     */
    public function LoyalsLogoImageResized()
    {
        if ($this->owner->LoyalsLogoImageExists()) {
            return $this->performImageResize('LoyalsLogoImage');
        }
    }
    
    /**
     * Answers a retina version of the logo image.
     *
     * @return Image
     */
    public function LoyalsLogoImageRetina()
    {
        if ($this->owner->LoyalsLogoImageExists()) {
            return $this->performImageResize('LoyalsLogoImage', true);
        }
    }
    
    /**
     * Answers the background-size for the retina version of the logo image.
     *
     * @return string
     */
    public function LoyalsLogoRetinaBackgroundSize()
    {
        if ($this->owner->LoyalsLogoImageExists()) {
            
            // Obtain Target Dimensions:
            
            list($tw, $th) = $this->getTargetDimensions('LoyalsLogoImage');
            
            // Answer Background Size:
            
            return "{$tw}px {$th}px";
            
        }
    }
    
    /**
     * Answers a resized version of the loading image.
     *
     * @return Image
     */
    public function LoyalsLoadingImageResized()
    {
        if ($this->owner->LoyalsLoadingImageExists()) {
            return $this->performImageResize('LoyalsLoadingImage');
        }
    }
    
    /**
     * Answers the target dimensions for the specified image.
     *
     * @param string $image
     * @return array
     */
    private function getTargetDimensions($image)
    {
        // Obtain Source Image:
        
        $si = $this->owner->{$image}();
        
        // Obtain Source Image Dimensions:
        
        $sw = $si->getWidth();
        $sh = $si->getHeight();
        
        // Obtain Target Image Dimensions:
        
        $wp = "{$image}Width";
        $hp = "{$image}Height";
        
        $tw = $this->owner->$wp;
        $th = $this->owner->$hp;
        
        // Calculate Target Width/Height (if required):
        
        if ($tw && !$th && $sw) {
            $th = round(($tw / $sw) * $sh);
        } elseif (!$tw && $th && $sh) {
            $tw = round(($th / $sh) * $sw);
        }
        
        // Answer Dimensions:
        
        return array($tw, $th);
    }
    
    /**
     * Answers a resized version of the loading image.
     *
     * @param string $image
     * @param boolean $retina
     * @return Image
     */
    private function performImageResize($image, $retina = false)
    {
        // Obtain Source Image:
        
        $si = $this->owner->{$image}();
        
        // Obtain Resize Method:
        
        $rp = "{$image}Resize";
        
        $tr = $this->owner->$rp;
        
        // Obtain Target Dimensions:
        
        list($tw, $th) = $this->getTargetDimensions($image);
        
        // Perform Image Resize:
        
        if ($tw && $th && $tr) {
            
            // Handle Retina Flag:
            
            if ($retina) {
                $tw = ($tw * 2);
                $th = ($th * 2);
            }
            
            // Build Argument Array:
            
            if (strpos($tr, 'Width') !== false) {
                $args = array($tw);
            } elseif (strpos($tr, 'Height') !== false) {
                $args = array($th);
            } else {
                $args = array($tw, $th);
            }
            
            // Call Resize Method:
            
            if ($si->hasMethod($tr)) {
                return call_user_func_array(array($si, $tr), $args);
            }
            
        }
        
        // Answer Source Image (no resize):
        
        return $si;
        
    }
}
