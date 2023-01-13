<?php


namespace JD\JdUsercentricsConfigurator\Resource\Rendering;


use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use JD\JdUsercentricsConfigurator\Domain\Model\Config;
use JD\JdUsercentricsConfigurator\Services\UsercentricsConfigurationService;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\Rendering\VimeoRenderer;

/**
 * Class JdVimeoRenderer
 *
 * @package JD\JdUsercentricsConfigurator\Resource\Rendering
 * @author Johannes Delesky, Developer
 */
class JdVimeoRenderer extends VimeoRenderer
{
    /**
     * Config
     *
     * @var Config $usercentricsConfiguration
     */
    protected $usercentricsConfiguration = NULL;

    /**
     * JdYoutubeRenderer constructor.
     *
     * @throws DBALException
     * @throws Exception
     */
    public function __construct()
    {
        $this->usercentricsConfiguration = UsercentricsConfigurationService::getUsercentricsConfigForRootPage(
            $GLOBALS['TSFE']->site->getRootPageId()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function render(FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false)
    {
        if ((bool)$this->usercentricsConfiguration['activate'] === TRUE && !empty($this->usercentricsConfiguration['settings_id'])) {
            $options = $this->collectOptions($options, $file);
            $src = $this->createVimeoUrl($options, $file);
            $options['data']['usercentrics'] = 'Vimeo';
            $attributes = $this->collectIframeAttributes($width, $height, $options);

            return sprintf(
                '<iframe uc-src="%s"%s></iframe>',
                htmlspecialchars($src, ENT_QUOTES | ENT_HTML5),
                empty($attributes) ? '' : ' ' . $this->implodeAttributes($attributes)
            );
        } else
            parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript);
    }
}