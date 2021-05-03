<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chessboard;

class ChessboardController extends Controller
{
    protected $files = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];  // TODO use the model constant on the Tile model

    public function run($size = 7)  // TODO replace hardcoded size
    {
        foreach ($this->getCoordinates($size) as $coordinate)
        {
            $startingCoordinate = "{$coordinate['rank']}{$coordinate['file']}";
            $this->runScenario($size, $startingCoordinate);
        }
    }

    protected function runScenario($size, $startingCoordinate)
    {
        $chessboard = $this->createChessboard($size);
        $this->addQueen($chessboard, $startingCoordinate);

        $saveTiles = $chessboard->tiles()->where('save', TRUE);

        /*
        This part of the run is vital, but does not work in its current state.
        The idea is to brute force the problem and find all viable solutions.
        The problem is that every Queen added results in a plethora of possible next steps.
        In order to brute force the problem you need to run all possible steps with the current setup on the chessboard.

        The way I see it there are 2 options:

        Option 1:
        Find a way to duplicate the current Chessboard and all its relations. 
        As far as I am aware this is not something that is supported by Laravel and persuing this option would likely result in something hacky.

        Option 2 :
        Implement a system that keeps track of the locations each new Queen is added and prevent duplication that way.
        This seems like the best option as it stands.
        
        In a work environment this would be a good point to include some other developers, to see if they have any fresh ideas.

        */
        while (0 < $saveTiles->count())
        {
            foreach ($saveTiles as $tile)
            {
                $this->addQueen($chessboard, $tile->coordinate);  // TODO duplicate chestboard, continue with the duplicated version
                $saveTiles = $chessboard->tiles()->where('save', TRUE);  // TODO is it necesarry to refresh the queryset
            }
        }
    }

    protected function addQueen($chessboard, $coordinate)
    {
        $tile = $chessboard->tiles()->get(['rank' => $coordinate[0], 'file' => $coordinate[1]]);
        $piece = $tile->piece()->create([
            'name' => 'Queen',
            'identifier' => 'Q'
        ]);

        $this->markUnsafeTiles($chessboard, $coordinate);
    }

    protected function createChessboard($size)
    {
        $chessboard = new Chessboard();
        $chessboard->size = $size;

        foreach ($this->getCoordinates($size) as $coordinate)
        {
            $chessboard->tiles()->create([
                'rank' => $coordinate['rank'], 
                'file' => $coordinate['file'],
            ]);
        }

        return $chessboard;
    }

    protected function getCoordinates($size)
    {
        $coordinates = [];

        for ($x = 1; $x <= $size; $x++)
        {
            for ($y = 0; $y < $size; $y++)
            {
                $coordinates[] = array('rank' => $x, 'file' => $this->files[$y]);
            }
        }

        return $coordinates;
    }

    protected function markUnsafeTiles($chessboard, $coordinate)
    {
        $chessboard->tiles()->where('rank', $coordinate[0])->update(['save' => FALSE]);  // TODO combine queries
        $chessboard->tiles()->where('file', $coordinate[1])->update(['save' => FALSE]);

        markDiagonals('up', 'right');
        markDiagonals('down', 'right');
        markDiagonals('down', 'left');
        markDiagonals('up', 'left');

        // TODO readability/docs/UNIT TESTS
        function markDiagonals($verticalDirection, $horizontalDirection)
        {
            $rank = $coordinate[0];
            $file = $coordinate[1];

            while (in_array($rank, range(1, 7)) && in_array(array_search($file, $files), range(0, 6)))
            {
                $chessboard->tiles()->where(['rank' => $rank, 'file' => $file])->update(['save' => FALSE]);

                // TODO find a better looking method
                if ($verticalDirection == 'up')
                {
                    $rank++;
                }
                else {
                    $rank--;
                }

                if ($horizontalDirection == 'right')
                {
                    $file++;
                }
                else
                {
                    $file--;
                }
            }
        }
    }
}
