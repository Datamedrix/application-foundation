<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Application\Services;

use Illuminate\Support\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class PassportService
{
    /**
     * @var null|[]
     */
    private $accessToken = null;

    /**
     * @var CacheContract
     */
    private $cache;

    /**
     * PassportService constructor.
     *
     * @param CacheContract $cache
     */
    public function __construct(CacheContract $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return array
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function accessToken(): array
    {
        if ($this->accessToken === null) {
            $user = auth()->user();
            if ($user === null || !($user instanceof User) || !in_array(HasApiTokens::class, class_uses($user))) {
                throw new \RuntimeException('No valid user is logged in!');
            }

            $cacheKey = md5(__METHOD__ . '-' . $user->getAuthIdentifier());
            $this->accessToken = $this->cache->get($cacheKey, null);

            if ($this->accessToken === null) {
                $token = $user->createToken(
                    'app-token-' . date('Ymd_His'),
                    [
                        '*',
                    ]
                );
                /** @var Carbon $expiresAt */
                $expiresAt = $token->token->expires_at;
                $this->accessToken = [
                    'token' => $token->accessToken,
                    'expiresAt' => $expiresAt->toIso8601String(),
                ];

                $this->cache->put($cacheKey, $this->accessToken, $expiresAt->diffInSeconds(Carbon::now()));
            }
        }

        return $this->accessToken;
    }

    /**
     * @return string
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAccessToken(): string
    {
        return $this->accessToken()['token'];
    }

    /**
     * @return Carbon
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Exception
     */
    public function getAccessTokenExpiresAt(): Carbon
    {
        return new Carbon($this->accessToken()['expiresAt']);
    }

    /**
     * @return int
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAccessTokenExpiresInMinutes(): int
    {
        return $this->getAccessTokenExpiresAt()->diffInMinutes(Carbon::now());
    }

    /**
     * @return int
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getAccessTokenExpiresInSeconds(): int
    {
        return $this->getAccessTokenExpiresAt()->diffInSeconds(Carbon::now());
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return 'com.app.' . md5(env('APP_NAME', 'Laravel'));
    }
}
