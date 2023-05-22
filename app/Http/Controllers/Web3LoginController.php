<?php

namespace App\Http\Controllers;

use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use App\Models\User;

class Web3LoginController
{
    public function message(): string
    {
        $nonce = Str::random();
        $message = "Sign this message to confirm you own this wallet address. This action will not cost any gas fees.\n\nNonce: " . $nonce;

        session()->put('sign_message', $message);

        return $message;
    }

    public function verify(Request $request): string
    {
        $result = $this->verifySignature(session()->pull('sign_message'), $request->signature, $request->address);
        if ($result == true) {
            if (User::where('eth_address', $request->address)->exists()) {
                $user = User::where('eth_address', $request->address)->first();
                auth()->login($user);
                return json_encode([
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Wallet Authenticated Successfully'
                ]);
            } else {
                return json_encode([
                    'success' => false,
                    'type' => 'error',
                    'message' => 'Your Account Dont Have Connected Wallet'
                ]);
            }
        }
    }

    protected function verifySignature(string $message, string $signature, string $address): bool
    {
        $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
        $sign = [
            'r' => substr($signature, 2, 64),
            's' => substr($signature, 66, 64),
        ];
        $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recid != ($recid & 1)) {
            return false;
        }

        $pubkey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recid);
        $derived_address = '0x' . substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);

        return (Str::lower($address) === $derived_address);
    }
}