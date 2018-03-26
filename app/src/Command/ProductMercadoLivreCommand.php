<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 25/03/2018
 * Time: 21:16
 */

namespace App\Command;

use App\Service\ProductMercadoLivreObservable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductMercadoLivreCommand extends Command
{
    /**
     * @var ProductMercadoLivreObservable
     */
    private $mercadoLivreObservable;

    public function __construct(ProductMercadoLivreObservable $mercadoLivreObservable)
    {
        $this->mercadoLivreObservable = $mercadoLivreObservable;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('app:verify')
            ->setDescription('Verifica melhorias de preço dos produtos no mercado livre');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Verificando produtos");

        $total = $this->mercadoLivreObservable->verify();

        $output->writeln("Produtos Verificados: {$total['totalProducts']}");
        $output->writeln("Notificações de reduções de preço: {$total['totalNotification']}");
        $output->writeln("Verificação concluída");
    }
}