<?php
class BoyerMooreAlgorith
{
	private $pattlen = 0;
	private $pattern = '';
	private $string = '';
	private $pos = 0;

	public function BoyerMoore($string,$pattern)
	{
		$this->_preProcessing($string,$pattern);

		$strlen = strlen($string);
		while($this->pos + $this->pattlen-1 < $strlen)
		{
			$matchPos = self::_processingSearch();

			if($matchPos == $this->pattlen)
			{
				return $this->pos;
			}
			else
			{
				$bcPos = self::_checkBadCharacter($matchPos);
				if($matchPos == $this->pattlen -1)
				{
					$this->pos += $bcPos;
				}
				else
				{
					$gsPos = self::_checkGoodSuffix($matchPos);
					$this->pos += max($bcPos,$gsPos);
				}
			}
		}
		return -1;
	}

	private function _checkGoodSuffix($matchPos)
	{
		$goodSuffix = substr($this->pattern, $matchPos+1);
		$gsPos = $matchPos+1;
		$gsLen = strlen($goodSuffix);
		while($gsPos >= $gsLen)
		{
			$gsPos -= $gsLen;
			if(substr($this->pattern,$gsPos,$gsLen) == $goodSuffix)
			{
				return $this->pattlen - 1 - ($gsPos-1 + $gsLen);
			}
		}
		while($gsLen > 0)
		{
			$gsLen--;
			$goodSuffix = substr($goodSuffix,1);
			if($matchPos+1 < $gsLen)
				continue;
			if(substr($this->pattern,0,$gsLen) == $goodSuffix)
			{
				return $this->pattlen - 1 - ($gsLen-1);
			}
		}
		return $this->pattlen;
	}

	private function _checkBadCharacter($matchPos)
	{
		$pos = $this->pos + $matchPos;
		for($i = $matchPos-1;$i>=0;$i--)
		{
			if($this->string[$pos] == $this->pattern[$i] )
			{

				return $matchPos - $i;
			}
		}

		return $matchPos + 1;
	}

	private function _processingSearch()
	{
		$endPos = $this->pos + $this->pattlen -1;

		for($i = $this->pattlen - 1,$j=0; $i >=0; $i--,$j++ )
		{
			if($this->pattern[$i] != $this->string[$endPos-$j])
				return $i;
		}

		return $this->pattlen;

	}

	private function _preProcessing($string,$pattern)
	{
		$this->pattlen = strlen($pattern);
		$this->pattern = $pattern;
		$this->string = $string;
		return ;
	}

}

$string = 'HERE IS A SIMPLE EXAMPLE';
$pattern = 'EXAMPLE'; 

$string = 'HERE IS A SIAXBLEXALE EXAMPLE';
$pattern =          'SSSBLEXALE'; 
function mtime()
{
	list($ms , $s) = explode(" ",microtime());
	return  (float)$s+(float)$ms;

}

$start = mtime();
for($i =0 ;$i<1000;$i++)
{
	$bmObj = new BoyerMooreAlgorith();
	$pos = $bmObj->BoyerMoore($string,$pattern);
}
$end = mtime();
echo ($end -$start)."\n";


$start = mtime();
for($j =0 ;$j<1000;$j++)
{
	var_dump(strpos($string,$pattern));
	exit;
}
$end = mtime();
echo ($end -$start)."\n";

?>
