<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;

class JwtHelper
{
    public static function parseTokenPayload(string $token): array
    {
        $tokenSegments = explode('.', $token);

        if (sizeof($tokenSegments) !== 3) {
            throw new \InvalidArgumentException('Неправильний формат JWT');
        }

        [$headerSegment, $bodySegment, $signatureSegment] = $tokenSegments;

        $bodySegment = str_replace(['-', '_'], ['+', '/'], $bodySegment);
        $decodedBody = base64_decode($bodySegment, true);

        if ($decodedBody === false || $decodedBody === null) {
            throw new \RuntimeException('Неможливо розкодувати вміст JWT');
        }

        $payloadArray = json_decode($decodedBody, true);
        return is_array($payloadArray) ? $payloadArray : [];
    }

    public static function getUserRole(Request $req): string
    {
        $jwt = $req->getSession()->get('jwt_token');

        if (empty($jwt)) {
            return 'Гість';
        }

        try {
            $info = self::parseTokenPayload($jwt);

            if (isset($info['roles']) && is_array($info['roles']) && count($info['roles']) > 0) {
                return $info['roles'][0];
            }

            return 'Невідомо';
        } catch (\Throwable $err) {
            return 'Помилка токена';
        }
    }
}
