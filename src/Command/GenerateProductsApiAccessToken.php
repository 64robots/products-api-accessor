<?php

namespace R64\ProductsApiAccessor\Command;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GenerateProductsApiAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:products-api-access-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate access token to be used with requests to Products API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client(['base_uri' => config('products.base_uri')]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = $this->getAccessToken();
        $this->setAccessTokenInEnvFile($token);

        $this->info('Access token set successfully');
    }

    private function getAccessToken()
    {
        $response = $this->client->request('POST', 'oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => config('products.client_id'),
                'client_secret' => config('products.client_secret'),
                'scope' => '*',
            ]
        ]);
        return json_decode((string) $response->getBody(), true)['access_token'];
    }

    private function setAccessTokenInEnvFile($accessToken)
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->tokenReplacementPattern(),
            'PRODUCTS_API_ACCESS_TOKEN='.$accessToken,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    private function tokenReplacementPattern()
    {
        $escaped = preg_quote('='.config('products.access_token'), '/');
        return "/^PRODUCTS_API_ACCESS_TOKEN{$escaped}/m";
    }
}
