<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KanbanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('boards')->insert([
            'name' => 'Life Sistemas',
        ]);
        $columns = [
            'Backlog' => ['pos'=>'1', 'max'=>'100'],
            'Validação.Fazendo' => ['pos'=>'2', 'max'=>'100'],
            'Validação.Pronto'=> ['pos'=>'3', 'max'=>'100'],
            'Priorizada'=> ['pos'=>'4', 'max'=>'12'],
            'Desenvolvimento.Fazendo'=> ['pos'=>'5', 'max'=>'12'],
            'Desenvolvimento.Pronto'=> ['pos'=>'6', 'max'=>'12'],
            'Teste'=> ['pos'=>'7', 'max'=>'6'],
            'Homologação.Aguardando'=> ['pos'=>'8', 'max'=>'100'],
            'Homologação.Pronto'=> ['pos'=>'9', 'max'=>'100'],
            'Entregue' => ['pos'=>'10', 'max'=>'100']
        ];
        foreach($columns as $name=>$column) {
            DB::table('columns')->insert([
                'board_id'=>'1',
                'board_position'=>$column['pos'],
                'name'=>$name,
                'max_cards'=>$column['max'],
                'min_cards'=>'1'
            ]);
        }
        echo "Dados inseridos no banco\n";
    }
}
