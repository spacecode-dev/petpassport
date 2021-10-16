<?php

namespace App\PetPassport\Models\Media;

use App\PetPassport\Models\Comment;
use App\PetPassport\Models\Like;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use App\PetPassport\Exceptions\EmbedNotFoundException;
use App\PetPassport\Exceptions\EmbedNotAllowedException;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Video extends Model
{

    public const SOURCE_TYPES = [
        0 => 'upload',
        1 => 'YouTube',
        2 => 'Vimeo',
        'upload'  => 0,
        'YouTube' => 1,
        'Vimeo'   => 2
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'owner_type',
        'album_id',
        'section'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'processed' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'processed' => false
    ];

    /**
     * @param $url
     * @return Video|bool
     * @throws EmbedNotAllowedException
     * @throws EmbedNotFoundException
     */
    public static function createFromUrl($url)
    {
        $url = parse_url($url);
        if (!$url) return false;
        switch ($url['host']) {
            case 'youtube.com':
            case 'www.youtube.com':
                if ($url['path'] !== '/watch') return false;
                parse_str($url['query'], $query);
                return self::createFromYouTubeID($query['v']);
            case 'youtu.be':
                $p = explode('/', $url['path']);
                return self::createFromYouTubeID($p[1]);
            case 'vimeo.com':
                $p = explode('/', $url['path']);
                return self::createFromVimeoID($p[1]);
            default:
                return false;
        }
    }

    /**
     * @param $data
     * @return $this
     */
    public function fillOembed($data)
    {
        if (isset($data['title'])) {
            $this->title = $data['title'];
        } else if (isset($data['description'])) {
            $this->description = $data['description'];
        } else if (isset($data['thumbnail_url'])) {
            $this->thumbnail = $data['thumbnail_url'];
        } else if (isset($data['provider_name']) && in_array($data['provider_name'], self::SOURCE_TYPES)) {
            $this->source_type = self::SOURCE_TYPES[$data['provider_name']];
        }
        return $this;
    }

    /**
     * @param $endpoint
     * @param $url
     * @return Video|bool
     * @throws EmbedNotAllowedException
     * @throws EmbedNotFoundException
     * @throws GuzzleException
     */
    private static function createFromOembed($endpoint, $url)
    {
        $client = new Client();
        $res = $client->request('GET', $endpoint, [
            'query' => array(
                'url' => $url,
                'maxwidth' => 1920,
                'maxheight' => 1080,
                'format' => 'json'
            ),
            'http_errors' => false
        ]);
        $status = $res->getStatusCode();
        if ($status !== 200) {
            switch ($status) {
                case 401:
                    throw new EmbedNotAllowedException();
                case 404:
                    throw new EmbedNotFoundException();
                default:
                    return false;
            }
        }
        $data = json_decode($res->getBody(), true);
        $video = new self();
        $video->fillOembed($data);
        $video->processed = true;
        return $video;
    }

    /**
     * @param $id
     * @return Video|bool
     * @throws EmbedNotAllowedException
     * @throws EmbedNotFoundException
     * @throws GuzzleException
     */
    public static function createFromYouTubeID($id)
    {
        $video = self::createFromOembed(
            'https://youtube.com/oembed',
            'https://www.youtube.com/watch?v=' . $id
        );
        if (!$video) return false;
        $video->source = $id;
        $video->source_type = self::SOURCE_TYPES['YouTube'];
        return $video;
    }

    /**
     * @param $id
     * @return Video|bool
     * @throws EmbedNotAllowedException
     * @throws EmbedNotFoundException
     * @throws GuzzleException
     */
    public static function createFromVimeoID($id)
    {
        $video = self::createFromOembed(
            'https://vimeo.com/api/oembed.json',
            'https://vimeo.com/' . $id
        );
        if (!$video) return false;
        $video->source = $id;
        $video->source_type = self::SOURCE_TYPES['Vimeo'];
        return $video;
    }

    /**
     * @return MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }

    /**
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'object');
    }
}
