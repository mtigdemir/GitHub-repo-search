<?php

namespace Mtigdemir\Github\Command;


use Mtigdemir\Github\Http\Client;
use Mtigdemir\Github\Repository;
use Mtigdemir\Github\Transformer\RepositoryTransformer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepositorySearch extends Command
{
    private $repository;

    private $transformer;

    /**
     * RepositorySearchFilter constructor.
     */
    public function __construct()
    {
        $client = new Client();
        $this->repository = new Repository($client);
        $this->transformer = new RepositoryTransformer();

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('search')
            ->setDescription('Search term in repositories')
            ->setHelp('This command will search repositories in description');

        $this
            ->addArgument('term', InputArgument::REQUIRED, 'Query is Required');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = $input->getArgument('term');
        $searchResult = $this->repository->searchIn('description', $query);
        $items = json_decode($searchResult, true)['items'];

        $response = $this->transformer
            ->convert($items)
            ->groupBy();

        foreach ($response as $key => $value) {
            $output->writeln($key . ': ' . $value['count']);
        }

        $output->writeln(count($items) . ' total result(s) found');
    }


}