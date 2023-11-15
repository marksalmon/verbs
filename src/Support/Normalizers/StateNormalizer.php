<?php

namespace Thunk\Verbs\Support\Normalizers;

use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Thunk\Verbs\Lifecycle\StateManager;
use Thunk\Verbs\State;

class StateNormalizer implements DenormalizerInterface, NormalizerInterface
{
	public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
	{
		return is_a($type, State::class, true) && is_numeric($data);
	}
	
	/** @param class-string<State> $type */
	public function denormalize(mixed $data, string $type, string $format = null, array $context = []): State
	{
		return app(StateManager::class)->load((int) $data, $type);
	}
	
	public function supportsNormalization(mixed $data, string $format = null): bool
	{
		return $data instanceof State;
	}
	
	public function normalize(mixed $object, string $format = null, array $context = []): string
	{
		if (! $object instanceof State) {
			throw new InvalidArgumentException(class_basename($this).' can only normalize State objects.');
		}
		
		return (string) $object->id;
	}
	
	public function getSupportedTypes(?string $format): array
	{
		return [State::class => false];
	}
}
