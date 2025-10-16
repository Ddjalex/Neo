<?php
// Site Settings Configuration

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../models/SiteSettings.php';

class Settings {
    private static $settingsModel = null;
    
    private static function getSettingsModel() {
        if (self::$settingsModel === null) {
            self::$settingsModel = new SiteSettings();
        }
        return self::$settingsModel;
    }
    
    // Get WhatsApp number from database
    public static function getWhatsAppNumber() {
        $model = self::getSettingsModel();
        $number = $model->get('whatsapp_number');
        return $number ?: '';
    }
    
    // Get Telegram link from database
    public static function getTelegramLink() {
        $model = self::getSettingsModel();
        $link = $model->get('telegram_link');
        return $link ?: '#';
    }
    
    // Get Facebook link from database
    public static function getFacebookLink() {
        $model = self::getSettingsModel();
        $link = $model->get('facebook_link');
        return $link ?: '#';
    }
    
    // Get Instagram link from database
    public static function getInstagramLink() {
        $model = self::getSettingsModel();
        $link = $model->get('instagram_link');
        return $link ?: '#';
    }
    
    // Get WhatsApp link from database
    public static function getWhatsAppSocialLink() {
        $number = self::getWhatsAppNumber();
        if (empty($number)) {
            return '#';
        }
        return 'https://wa.me/' . $number;
    }
    
    // WhatsApp Business Number (format: country code + number without + or spaces)
    // This is now stored in database, use Settings::getWhatsAppNumber()
    public static $whatsapp_number = '251911234567'; // Kept for backwards compatibility
    
    // Company Information
    public static $company_name = 'NEO Printing and Advertising';
    public static $company_email = 'info@neoprinting.com';
    
    // Social Media Links (kept for backwards compatibility)
    public static $telegram = 'https://t.me/neoprinting';
    public static $facebook = 'https://facebook.com/neoprinting';
    public static $instagram = 'https://instagram.com/neoprinting';
    
    /**
     * Get safe base URL for the site (prevents host header injection)
     * @return string Safe base URL
     */
    public static function getBaseUrl() {
        $domain = getenv('REPLIT_DEV_DOMAIN') ?: 'neoprinting.com';
        return 'https://' . htmlspecialchars($domain, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Create SEO-friendly meta description (max 155 characters)
     * @param string $text The text to use for description
     * @param int $maxLength Maximum length (default 155)
     * @return string Truncated description
     */
    public static function createMetaDescription($text, $maxLength = 155) {
        $clean = strip_tags($text);
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = trim($clean);
        
        if (mb_strlen($clean) <= $maxLength) {
            return htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
        }
        
        $truncated = mb_substr($clean, 0, $maxLength - 3);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }
        
        return htmlspecialchars($truncated . '...', ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Get default OG image for services without images
     * @return string Default image path
     */
    public static function getDefaultOGImage() {
        return '/assets/images/logo.png';
    }
    
    /**
     * Generate WhatsApp link with pre-filled message including website URL
     * @param string $service_name The name of the service
     * @return string WhatsApp URL
     */
    public static function getWhatsAppLink($service_name = '') {
        $websiteUrl = self::getBaseUrl();
        
        $message = "Hello! I'm interested in ";
        if (!empty($service_name)) {
            $message .= $service_name . " service from NEO Printing and Advertising";
        } else {
            $message .= "your services from NEO Printing and Advertising";
        }
        $message .= ". Can you provide more information?\n\n";
        
        // Add service link
        if (!empty($service_name)) {
            $serviceSlug = strtolower(str_replace(' ', '-', $service_name));
            $message .= "Service link: " . $websiteUrl . "/services/" . $serviceSlug;
        } else {
            $message .= "Website: " . $websiteUrl;
        }
        
        return 'https://wa.me/' . self::getWhatsAppNumber() . '?text=' . urlencode($message);
    }
}
